-- AssetFix AI — PostgreSQL 16 Database Schema
-- Kryteria: 10 (PostgreSQL), 11 (Złożoność bazy), 23 (Role), 26 (Referencje / ON DELETE)

-- ============================================================================
-- 1. TYPY WYLICZENIOWE (ENUM)
-- ============================================================================

CREATE TYPE ticket_priority AS ENUM ('LOW', 'MEDIUM', 'HIGH', 'CRITICAL');
CREATE TYPE ticket_status AS ENUM ('OPEN', 'IN_PROGRESS', 'RESOLVED', 'CLOSED');
CREATE TYPE asset_status AS ENUM ('OPERATIONAL', 'IN_REPAIR', 'OUT_OF_SERVICE');
CREATE TYPE reminder_status AS ENUM ('SENT', 'FAILED');

-- ============================================================================
-- 2. TABELE SŁOWNIKOWE I UŻYTKOWNICY
-- ============================================================================

CREATE TABLE roles (
    id BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    name VARCHAR(32) NOT NULL UNIQUE,
    description VARCHAR(255) NULL,
    CONSTRAINT roles_name_check CHECK (name IN ('ADMIN', 'TECHNICIAN'))
);

CREATE TABLE users (
    id BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    role_id BIGINT NOT NULL REFERENCES roles(id) ON DELETE RESTRICT,
    email VARCHAR(150) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    first_name VARCHAR(80) NOT NULL,
    last_name VARCHAR(80) NOT NULL,
    employee_code VARCHAR(32) NULL UNIQUE,
    phone VARCHAR(32) NULL,
    base_location VARCHAR(120) NULL,
    avatar_path VARCHAR(255) NULL,
    is_active BOOLEAN NOT NULL DEFAULT TRUE,
    created_at TIMESTAMPTZ NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMPTZ NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- ============================================================================
-- 3. KLIENCI I PARK MASZYNOWY (EAM)
-- ============================================================================

CREATE TABLE clients (
    id BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    address VARCHAR(200) NOT NULL,
    city VARCHAR(100) NOT NULL,
    contact_email VARCHAR(150) NULL,
    contact_phone VARCHAR(32) NULL,
    latitude NUMERIC(9, 6) NULL,
    longitude NUMERIC(9, 6) NULL,
    created_at TIMESTAMPTZ NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE asset_categories (
    id BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    description VARCHAR(255) NULL
);

CREATE TABLE assets (
    id BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    client_id BIGINT NOT NULL REFERENCES clients(id) ON DELETE RESTRICT,
    category_id BIGINT NOT NULL REFERENCES asset_categories(id) ON DELETE RESTRICT,
    assigned_technician_id BIGINT NULL REFERENCES users(id) ON DELETE SET NULL,
    name VARCHAR(150) NOT NULL,
    serial_number VARCHAR(64) NOT NULL UNIQUE,
    status asset_status NOT NULL DEFAULT 'OPERATIONAL',
    manufacturer VARCHAR(120) NULL,
    model VARCHAR(120) NULL,
    production_year SMALLINT NULL,
    udt_number VARCHAR(64) NULL,
    location_details VARCHAR(255) NULL,
    last_inspection_at DATE NULL,
    next_inspection_at DATE NULL,
    udt_valid_until DATE NULL,
    operating_hours INTEGER NOT NULL DEFAULT 0,
    created_at TIMESTAMPTZ NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMPTZ NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT assets_production_year_check
        CHECK (production_year IS NULL OR (production_year >= 1950 AND production_year <= 2100)),
    CONSTRAINT assets_operating_hours_check
        CHECK (operating_hours >= 0)
);

-- ============================================================================
-- 4. ZGŁOSZENIA AWARII (TICKETS), HISTORIA I ZAŁĄCZNIKI
-- ============================================================================

CREATE TABLE tickets (
    id BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    asset_id BIGINT NOT NULL REFERENCES assets(id) ON DELETE RESTRICT,
    reported_by BIGINT NOT NULL REFERENCES users(id) ON DELETE RESTRICT,
    assigned_to BIGINT NULL REFERENCES users(id) ON DELETE SET NULL,
    title VARCHAR(180) NOT NULL,
    description TEXT NOT NULL,
    priority ticket_priority NOT NULL DEFAULT 'MEDIUM',
    status ticket_status NOT NULL DEFAULT 'OPEN',
    ai_suggestion TEXT NULL,
    scheduled_for TIMESTAMPTZ NULL,
    created_at TIMESTAMPTZ NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMPTZ NOT NULL DEFAULT CURRENT_TIMESTAMP,
    closed_at TIMESTAMPTZ NULL,
    CONSTRAINT tickets_closed_at_check
        CHECK (closed_at IS NULL OR status = 'CLOSED')
);

CREATE TABLE ticket_history (
    id BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    ticket_id BIGINT NOT NULL REFERENCES tickets(id) ON DELETE CASCADE,
    changed_by BIGINT NULL REFERENCES users(id) ON DELETE SET NULL,
    old_status ticket_status NULL,
    new_status ticket_status NOT NULL,
    note TEXT NULL,
    created_at TIMESTAMPTZ NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE ticket_photos (
    id BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    ticket_id BIGINT NOT NULL REFERENCES tickets(id) ON DELETE CASCADE,
    uploaded_by BIGINT NULL REFERENCES users(id) ON DELETE SET NULL,
    file_path VARCHAR(255) NOT NULL,
    original_name VARCHAR(255) NOT NULL,
    mime_type VARCHAR(64) NOT NULL,
    size_bytes INTEGER NOT NULL,
    created_at TIMESTAMPTZ NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT ticket_photos_size_check CHECK (size_bytes > 0)
);

-- ============================================================================
-- 5. LOGI PRZYPOMNIEŃ CRON (PRZEGLĄDY OKRESOWE / UDT)
-- ============================================================================

CREATE TABLE reminder_logs (
    id BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    asset_id BIGINT NOT NULL REFERENCES assets(id) ON DELETE CASCADE,
    reminder_for_date DATE NOT NULL,
    recipient_email VARCHAR(150) NOT NULL,
    status reminder_status NOT NULL,
    error_message TEXT NULL,
    sent_at TIMESTAMPTZ NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT reminder_logs_unique_asset_date UNIQUE (asset_id, reminder_for_date)
);

-- ============================================================================
-- 6. INDEKSY WYDAJNOŚCIOWE
-- ============================================================================

CREATE INDEX idx_users_role_id ON users (role_id);
CREATE INDEX idx_assets_client_id ON assets (client_id);
CREATE INDEX idx_assets_category_id ON assets (category_id);
CREATE INDEX idx_assets_assigned_technician_id ON assets (assigned_technician_id);
CREATE INDEX idx_assets_next_inspection_at ON assets (next_inspection_at);
CREATE INDEX idx_assets_status ON assets (status);

CREATE INDEX idx_tickets_asset_id ON tickets (asset_id);
CREATE INDEX idx_tickets_reported_by ON tickets (reported_by);
CREATE INDEX idx_tickets_assigned_to ON tickets (assigned_to);
CREATE INDEX idx_tickets_status ON tickets (status);
CREATE INDEX idx_tickets_priority ON tickets (priority);
CREATE INDEX idx_tickets_created_at ON tickets (created_at DESC);

CREATE INDEX idx_ticket_history_ticket_id ON ticket_history (ticket_id, created_at DESC);
CREATE INDEX idx_ticket_photos_ticket_id ON ticket_photos (ticket_id);
