-- AssetFix AI — PostgreSQL 16 Views, Triggers & Functions
-- Kryterium 25: Widok, trigger, funkcja, operacja atomowa

-- ============================================================================
-- 1. AUTOMATYCZNE ZARZĄDZANIE updated_at ORAZ closed_at
-- ============================================================================

CREATE OR REPLACE FUNCTION fn_set_updated_at()
RETURNS TRIGGER
LANGUAGE plpgsql
AS $$
BEGIN
    NEW.updated_at := CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$;

CREATE TRIGGER trg_users_updated_at
    BEFORE UPDATE ON users
    FOR EACH ROW
    EXECUTE FUNCTION fn_set_updated_at();

CREATE TRIGGER trg_assets_updated_at
    BEFORE UPDATE ON assets
    FOR EACH ROW
    EXECUTE FUNCTION fn_set_updated_at();

CREATE TRIGGER trg_tickets_updated_at
    BEFORE UPDATE ON tickets
    FOR EACH ROW
    EXECUTE FUNCTION fn_set_updated_at();

CREATE OR REPLACE FUNCTION fn_sync_ticket_closed_at()
RETURNS TRIGGER
LANGUAGE plpgsql
AS $$
BEGIN
    IF NEW.status = 'CLOSED' AND OLD.status IS DISTINCT FROM 'CLOSED' THEN
        NEW.closed_at := COALESCE(NEW.closed_at, CURRENT_TIMESTAMP);
    ELSIF NEW.status <> 'CLOSED' THEN
        NEW.closed_at := NULL;
    END IF;
    RETURN NEW;
END;
$$;

CREATE TRIGGER trg_ticket_sync_closed_at
    BEFORE UPDATE OF status ON tickets
    FOR EACH ROW
    EXECUTE FUNCTION fn_sync_ticket_closed_at();

-- ============================================================================
-- 2. TRIGGER HISTORII ZMIAN STATUSU ZGŁOSZENIA
-- ============================================================================

CREATE OR REPLACE FUNCTION fn_log_ticket_status_change()
RETURNS TRIGGER
LANGUAGE plpgsql
AS $$
BEGIN
    IF OLD.status IS DISTINCT FROM NEW.status THEN
        INSERT INTO ticket_history (
            ticket_id,
            changed_by,
            old_status,
            new_status,
            note
        ) VALUES (
            NEW.id,
            NEW.assigned_to,
            OLD.status,
            NEW.status,
            'Automatyczny zapis zmiany statusu przez trigger bazy danych'
        );
    END IF;
    RETURN NEW;
END;
$$;

CREATE TRIGGER trg_ticket_status_history
    AFTER UPDATE OF status ON tickets
    FOR EACH ROW
    EXECUTE FUNCTION fn_log_ticket_status_change();

-- ============================================================================
-- 3. WIDOKI (VIEWS) DLA LIST ZGŁOSZEŃ I PRZEGLĄDÓW UDT
-- ============================================================================

CREATE OR REPLACE VIEW v_ticket_overview AS
SELECT
    t.id,
    t.title,
    t.description,
    t.priority,
    t.status,
    t.ai_suggestion,
    t.scheduled_for,
    t.created_at,
    t.updated_at,
    t.closed_at,
    a.id AS asset_id,
    a.name AS asset_name,
    a.serial_number AS asset_serial_number,
    a.status AS asset_status,
    ac.name AS category_name,
    c.id AS client_id,
    c.name AS client_name,
    c.city AS client_city,
    c.address AS client_address,
    c.latitude AS client_latitude,
    c.longitude AS client_longitude,
    t.reported_by,
    CONCAT(rep.first_name, ' ', rep.last_name) AS reporter_name,
    t.assigned_to,
    CONCAT(tech.first_name, ' ', tech.last_name) AS technician_name,
    tech.email AS technician_email
FROM tickets t
JOIN assets a ON a.id = t.asset_id
JOIN asset_categories ac ON ac.id = a.category_id
JOIN clients c ON c.id = a.client_id
JOIN users rep ON rep.id = t.reported_by
LEFT JOIN users tech ON tech.id = t.assigned_to;

CREATE OR REPLACE VIEW v_upcoming_inspections AS
SELECT
    a.id AS asset_id,
    a.name AS asset_name,
    a.serial_number,
    a.status AS asset_status,
    a.udt_number,
    a.last_inspection_at,
    a.next_inspection_at,
    a.udt_valid_until,
    (a.next_inspection_at - CURRENT_DATE) AS days_until_inspection,
    ac.name AS category_name,
    c.name AS client_name,
    c.city AS client_city,
    c.contact_email AS client_email,
    u.id AS technician_id,
    CONCAT(u.first_name, ' ', u.last_name) AS technician_name,
    u.email AS technician_email
FROM assets a
JOIN asset_categories ac ON ac.id = a.category_id
JOIN clients c ON c.id = a.client_id
LEFT JOIN users u ON u.id = a.assigned_technician_id
WHERE a.next_inspection_at IS NOT NULL
ORDER BY a.next_inspection_at ASC;

-- ============================================================================
-- 4. FUNKCJE SKŁADOWANE
-- ============================================================================

CREATE OR REPLACE FUNCTION fn_open_tickets_for_technician(p_user_id BIGINT)
RETURNS INTEGER
LANGUAGE sql
STABLE
AS $$
    SELECT COUNT(*)::INTEGER
    FROM tickets
    WHERE assigned_to = p_user_id
      AND status IN ('OPEN', 'IN_PROGRESS');
$$;

CREATE OR REPLACE FUNCTION fn_create_ticket(
    p_asset_id BIGINT,
    p_reported_by BIGINT,
    p_assigned_to BIGINT,
    p_title VARCHAR(180),
    p_description TEXT,
    p_priority ticket_priority DEFAULT 'MEDIUM'
)
RETURNS BIGINT
LANGUAGE plpgsql
AS $$
DECLARE
    v_ticket_id BIGINT;
BEGIN
    INSERT INTO tickets (
        asset_id,
        reported_by,
        assigned_to,
        title,
        description,
        priority,
        status
    ) VALUES (
        p_asset_id,
        p_reported_by,
        p_assigned_to,
        p_title,
        p_description,
        p_priority,
        'OPEN'
    )
    RETURNING id INTO v_ticket_id;

    INSERT INTO ticket_history (
        ticket_id,
        changed_by,
        old_status,
        new_status,
        note
    ) VALUES (
        v_ticket_id,
        p_reported_by,
        NULL,
        'OPEN',
        'Utworzenie zgłoszenia awarii'
    );

    RETURN v_ticket_id;
END;
$$;
