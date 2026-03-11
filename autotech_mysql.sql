-- ============================================================
--  AutoTech Pro — Script MySQL Workbench
--  Cole este script inteiro no MySQL Workbench e execute (Ctrl+Shift+Enter)
-- ============================================================

CREATE DATABASE IF NOT EXISTS autotech_pro
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE autotech_pro;

-- ------------------------------------------------------------
-- TABELA: users
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `users` (
    `id`                BIGINT UNSIGNED  NOT NULL AUTO_INCREMENT,
    `full_name`         VARCHAR(255)     NOT NULL,
    `email`             VARCHAR(255)     NOT NULL,
    `email_verified_at` TIMESTAMP        NULL DEFAULT NULL,
    `password`          VARCHAR(255)     NOT NULL,
    `tax_id`            VARCHAR(20)      NULL COMMENT 'CPF ou CNPJ',
    `role`              ENUM('manager','attendant','mechanic','customer') NOT NULL DEFAULT 'customer',
    `remember_token`    VARCHAR(100)     NULL,
    `created_at`        TIMESTAMP        NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`        TIMESTAMP        NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `users_email_unique` (`email`),
    UNIQUE KEY `users_tax_id_unique` (`tax_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- TABELA: vehicles
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `vehicles` (
    `id`            BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `customer_id`   BIGINT UNSIGNED NOT NULL,
    `license_plate` VARCHAR(10)     NOT NULL,
    `brand`         VARCHAR(100)    NOT NULL,
    `model`         VARCHAR(100)    NOT NULL,
    `fipe_code`     VARCHAR(20)     NULL,
    `created_at`    TIMESTAMP       NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`    TIMESTAMP       NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `vehicles_plate_unique` (`license_plate`),
    KEY `vehicles_customer_fk` (`customer_id`),
    CONSTRAINT `vehicles_customer_fk`
        FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- TABELA: service_orders
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `service_orders` (
    `id`                    BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `vehicle_id`            BIGINT UNSIGNED NOT NULL,
    `attendant_id`          BIGINT UNSIGNED NOT NULL,
    `mechanic_id`           BIGINT UNSIGNED NULL,
    `customer_symptoms`     TEXT            NULL,
    `mechanic_diagnosis`    TEXT            NULL,
    `status`                ENUM('received','diagnostic','awaiting_approval','in_repair','ready','delivered')
                            NOT NULL DEFAULT 'received',
    `customer_approval`     TINYINT(1)      NOT NULL DEFAULT 0,
    `labor_warranty_expiry` DATE            NULL,
    `opened_at`             TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `created_at`            TIMESTAMP       NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`            TIMESTAMP       NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `so_vehicle_fk`    (`vehicle_id`),
    KEY `so_attendant_fk`  (`attendant_id`),
    KEY `so_mechanic_fk`   (`mechanic_id`),
    KEY `so_status_idx`    (`status`),
    CONSTRAINT `so_vehicle_fk`   FOREIGN KEY (`vehicle_id`)   REFERENCES `vehicles` (`id`) ON DELETE CASCADE,
    CONSTRAINT `so_attendant_fk` FOREIGN KEY (`attendant_id`) REFERENCES `users`    (`id`) ON UPDATE CASCADE,
    CONSTRAINT `so_mechanic_fk`  FOREIGN KEY (`mechanic_id`)  REFERENCES `users`    (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- TABELA: order_photos
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `order_photos` (
    `id`         BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `order_id`   BIGINT UNSIGNED NOT NULL,
    `photo_url`  VARCHAR(500)    NOT NULL,
    `entry_exit` ENUM('entry','exit') NOT NULL DEFAULT 'entry',
    `position`   ENUM('front','rear','left_side','right_side','interior') NOT NULL,
    `created_at` TIMESTAMP       NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `op_order_fk` (`order_id`),
    CONSTRAINT `op_order_fk` FOREIGN KEY (`order_id`) REFERENCES `service_orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- TABELA: parts
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `parts` (
    `id`             BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name`           VARCHAR(255)    NOT NULL,
    `part_number`    VARCHAR(100)    NULL,
    `stock_quantity` INT             NOT NULL DEFAULT 0,
    `unit_price`     DECIMAL(10,2)   NOT NULL DEFAULT 0.00,
    `created_at`     TIMESTAMP       NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`     TIMESTAMP       NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- TABELA: services_catalog
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `services_catalog` (
    `id`          BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `description` VARCHAR(255)    NOT NULL,
    `hourly_rate` DECIMAL(10,2)   NOT NULL DEFAULT 0.00,
    `created_at`  TIMESTAMP       NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`  TIMESTAMP       NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- TABELAS DE INFRAESTRUTURA LARAVEL
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `migrations` (
    `id`        INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `migration` VARCHAR(255) NOT NULL,
    `batch`     INT          NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
    `email`      VARCHAR(255) NOT NULL,
    `token`      VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP    NULL,
    PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `sessions` (
    `id`            VARCHAR(255)    NOT NULL,
    `user_id`       BIGINT UNSIGNED NULL,
    `ip_address`    VARCHAR(45)     NULL,
    `user_agent`    TEXT            NULL,
    `payload`       LONGTEXT        NOT NULL,
    `last_activity` INT             NOT NULL,
    PRIMARY KEY (`id`),
    KEY `sessions_user_id_idx`       (`user_id`),
    KEY `sessions_last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `cache` (
    `key`        VARCHAR(255) NOT NULL,
    `value`      MEDIUMTEXT   NOT NULL,
    `expiration` INT          NOT NULL,
    PRIMARY KEY (`key`),
    KEY `cache_expiration_idx` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `cache_locks` (
    `key`        VARCHAR(255) NOT NULL,
    `owner`      VARCHAR(255) NOT NULL,
    `expiration` INT          NOT NULL,
    PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `jobs` (
    `id`           BIGINT UNSIGNED  NOT NULL AUTO_INCREMENT,
    `queue`        VARCHAR(255)     NOT NULL,
    `payload`      LONGTEXT         NOT NULL,
    `attempts`     TINYINT UNSIGNED NOT NULL,
    `reserved_at`  INT UNSIGNED     NULL,
    `available_at` INT UNSIGNED     NOT NULL,
    `created_at`   INT UNSIGNED     NOT NULL,
    PRIMARY KEY (`id`),
    KEY `jobs_queue_idx` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `job_batches` (
    `id`             VARCHAR(255) NOT NULL,
    `name`           VARCHAR(255) NOT NULL,
    `total_jobs`     INT          NOT NULL,
    `pending_jobs`   INT          NOT NULL,
    `failed_jobs`    INT          NOT NULL,
    `failed_job_ids` LONGTEXT     NOT NULL,
    `options`        MEDIUMTEXT   NULL,
    `cancelled_at`   INT          NULL, 
    `created_at`     INT          NOT NULL,
    `finished_at`    INT          NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `failed_jobs` (
    `id`         BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `uuid`       VARCHAR(255)    NOT NULL,
    `connection` LONGTEXT        NOT NULL,
    `queue`      LONGTEXT        NOT NULL,
    `payload`    LONGTEXT        NOT NULL,
    `exception`  LONGTEXT        NOT NULL,
    `failed_at`  TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
--  USUÁRIOS DE TESTE
--  Todos com senha: password
--  Hash gerado com password_hash('password', PASSWORD_DEFAULT)
-- ============================================================

INSERT INTO `users` (`full_name`, `email`, `password`, `tax_id`, `role`, `created_at`) VALUES
(
    'Administrador Teste',
    'teste@autotech.com',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    '111.111.111-11',
    'manager',
    NOW()
),
(
    'Atendente Teste',
    'atendente@autotech.com',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    '222.222.222-22',
    'attendant',
    NOW()
),
(
    'Mecânico Teste',
    'mecanico@autotech.com',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    '333.333.333-33',
    'mechanic',
    NOW()
),
(
    'Cliente Teste',
    'cliente@autotech.com',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    '444.444.444-44',
    'customer',
    NOW()
);

-- ============================================================
--  ACESSO AO SISTEMA
--  ┌─────────────────────────────┬────────────┬──────────┐
--  │ E-mail                      │ Cargo      │ Senha    │
--  ├─────────────────────────────┼────────────┼──────────┤
--  │ teste@autotech.com          │ Gerente    │ password │
--  │ atendente@autotech.com      │ Atendente  │ password │
--  │ mecanico@autotech.com       │ Mecânico   │ password │
--  │ cliente@autotech.com        │ Cliente    │ password │
--  └─────────────────────────────┴────────────┴──────────┘
--
--  Após o primeiro acesso, troque as senhas pelo sistema.
--
--  Configure o .env do projeto:
--    DB_CONNECTION=mysql
--    DB_HOST=127.0.0.1
--    DB_PORT=3306
--    DB_DATABASE=autotech_pro
--    DB_USERNAME=root
--    DB_PASSWORD=sua_senha_aqui
-- ============================================================

-- ============================================================
-- POPULANDO O BANCO DE DADOS (AJUSTADO)
-- ============================================================

-- 1. USERS (IDs gerados: 5 a 24)
INSERT INTO `users` (`full_name`, `email`, `password`, `tax_id`, `role`) VALUES
('João Silva', 'joao@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '123.456.789-01', 'customer'),
('Maria Oliveira', 'maria@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '123.456.789-02', 'customer'),
('Pedro Santos', 'pedro@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '123.456.789-03', 'customer'),
('Ana Costa', 'ana@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '123.456.789-04', 'customer'),
('Lucas Pereira', 'lucas@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '123.456.789-05', 'customer'),
('Julia Rodrigues', 'julia@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '123.456.789-06', 'customer'),
('Carlos Souza', 'carlos@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '123.456.789-07', 'customer'),
('Beatriz Lima', 'beatriz@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '123.456.789-08', 'customer'),
('Marcos Rocha', 'marcos@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '123.456.789-09', 'customer'),
('Fernanda Alves', 'fernanda@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '123.456.789-10', 'customer'),
('Ricardo Gomes', 'ricardo@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '123.456.789-11', 'customer'),
('Camila Martins', 'camila@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '123.456.789-12', 'customer'),
('Bruno Mendes', 'bruno@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '123.456.789-13', 'customer'),
('Amanda Freitas', 'amanda@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '123.456.789-14', 'customer'),
('Diego Ramos', 'diego@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '123.456.789-15', 'customer'),
('Patrícia Barbosa', 'patricia@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '123.456.789-16', 'customer'),
('Hugo Viana', 'hugo@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '123.456.789-17', 'customer'),
('Sonia Ribeiro', 'sonia@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '123.456.789-18', 'customer'),
('Gabriel Castro', 'gabriel@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '123.456.789-19', 'customer'),
('Vanessa Nunes', 'vanessa@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '123.456.789-20', 'customer');

-- 2. VEHICLES (IDs gerados: 1 a 20)
-- Vinculando aos clientes acima (IDs 5 a 24)
INSERT INTO `vehicles` (`customer_id`, `license_plate`, `brand`, `model`, `fipe_code`) VALUES
(5, 'ABC1D11', 'Volkswagen', 'Gol', '005212-4'), (6, 'EFG2H22', 'Fiat', 'Uno', '001211-4'),
(7, 'IJK3L33', 'Chevrolet', 'Onix', '004451-2'), (8, 'MNO4P44', 'Ford', 'Ka', '003321-0'),
(9, 'QRS5T55', 'Toyota', 'Corolla', '002154-7'), (10, 'UVW6X66', 'Honda', 'Civic', '002144-0'),
(11, 'YZA7B77', 'Hyundai', 'HB20', '005432-1'), (12, 'BCD8E88', 'Renault', 'Kwid', '006543-2'),
(13, 'FGH9I99', 'Jeep', 'Renegade', '007654-3'), (14, 'JKL0M00', 'Nissan', 'Versa', '008765-4'),
(15, 'NOP1Q11', 'Volkswagen', 'Polo', '005215-9'), (16, 'RST2U22', 'Chevrolet', 'Cruze', '004455-5'),
(17, 'VWX3Y33', 'Fiat', 'Argo', '001215-7'), (18, 'ZAB4C44', 'Toyota', 'Yaris', '002158-0'),
(19, 'DEF5G55', 'Mitsubishi', 'L200', '009876-5'), (20, 'HIJ6K66', 'Ford', 'Ranger', '003325-3'),
(21, 'LMN7O77', 'Honda', 'HR-V', '002148-2'), (22, 'PQR8S88', 'Hyundai', 'Creta', '005435-6'),
(23, 'TUV9W99', 'Nissan', 'Kicks', '008768-9'), (24, 'XYZ0A00', 'Renault', 'Duster', '006546-7');

-- 3. PARTS (Aspas simples corrigidas)
INSERT INTO `parts` (`name`, `part_number`, `stock_quantity`, `unit_price`) VALUES
('Pastilha de Freio', 'PF-001', 50, 120.50), ('Filtro de Óleo', 'FO-010', 100, 35.00),
('Óleo 5W30 Sintético', 'OL-530', 200, 45.90), ('Vela de Ignição', 'VI-202', 80, 25.00),
('Amortecedor Dianteiro', 'AM-500', 20, 350.00), ('Bateria 60Ah', 'BT-060', 15, 480.00),
('Filtro de Ar', 'FA-101', 40, 42.00), ('Filtro Combustível', 'FC-303', 45, 28.00),
('Correia Dentada', 'CD-404', 12, 110.00), ('Disco de Freio', 'DF-505', 30, 180.00),
('Lâmpada Farol H4', 'LP-H4', 60, 15.00), ('Palheta Limpador', 'PL-009', 35, 65.00),
('Bomba d''Água', 'BA-777', 10, 220.00), ('Terminal Direção', 'TD-888', 25, 85.00),
('Radiador', 'RD-999', 5, 550.00), ('Bobina Ignição', 'BI-111', 18, 195.00),
('Sensor Estacionamento', 'SE-222', 14, 130.00), ('Cabo de Vela', 'CV-333', 22, 95.00),
('Pneu 175/70 R14', 'PN-175', 40, 320.00), ('Junta Cabeçote', 'JC-444', 8, 145.00);

-- 4. SERVICES_CATALOG
INSERT INTO `services_catalog` (`description`, `hourly_rate`) VALUES
('Troca de Óleo', 80.00), ('Revisão Freios', 150.00), ('Alinhamento', 120.00),
('Limpeza de Bicos', 180.00), ('Troca Amortecedor', 250.00), ('Diagnóstico Scanner', 100.00),
('Carga de Gás AC', 160.00), ('Troca Correia', 450.00), ('Higienização AC', 90.00),
('Troca de Embreagem', 600.00), ('Reparo Suspensão', 300.00), ('Troca Bateria', 40.00),
('Regulagem Válvulas', 220.00), ('Troca de Velas', 70.00), ('Elétrica Geral', 130.00),
('Troca Arrefecimento', 85.00), ('Polimento Farol', 110.00), ('Cambagem', 140.00),
('Troca Pastilhas', 200.00), ('Limpeza Radiador', 170.00);

-- 5. SERVICE_ORDERS (IDs gerados: 1 a 20)
-- IMPORTANTE: Referenciando vehicle_id de 1 a 20 que foram criados no passo 2.
INSERT INTO `service_orders` (`vehicle_id`, `attendant_id`, `mechanic_id`, `customer_symptoms`, `status`) VALUES
(1, 2, 3, 'Barulho ao frear', 'received'), (2, 2, 3, 'Luz da injeção acesa', 'diagnostic'),
(3, 2, 3, 'Carro puxando', 'awaiting_approval'), (4, 2, 3, 'Ar não gela', 'in_repair'),
(5, 2, 3, 'Dificuldade partida', 'ready'), (6, 2, 3, 'Vazamento óleo', 'delivered'),
(7, 2, 3, 'Pedal freio baixo', 'received'), (8, 2, 3, 'Fumaça escape', 'diagnostic'),
(9, 2, 3, 'Trepidando', 'in_repair'), (10, 2, 3, 'Troca preventiva', 'ready'),
(11, 2, 3, 'Luz ABS', 'received'), (12, 2, 3, 'Barulho suspensão', 'diagnostic'),
(13, 2, 3, 'Limpador travado', 'awaiting_approval'), (14, 2, 3, 'Pneus gastos', 'in_repair'),
(15, 2, 3, 'Cheiro queimado', 'ready'), (16, 2, 3, 'Bateria fraca', 'delivered'),
(17, 2, 3, 'Motor falhando', 'received'), (18, 2, 3, 'Barulho correia', 'diagnostic'),
(19, 2, 3, 'Água sumindo', 'in_repair'), (20, 2, 3, 'Revisão geral', 'ready');

-- 6. ORDER_PHOTOS
INSERT INTO `order_photos` (`order_id`, `photo_url`, `entry_exit`, `position`) VALUES
(1, 'storage/os1.jpg', 'entry', 'front'), (2, 'storage/os2.jpg', 'entry', 'rear'),
(3, 'storage/os3.jpg', 'entry', 'left_side'), (4, 'storage/os4.jpg', 'entry', 'right_side'),
(5, 'storage/os5.jpg', 'entry', 'interior'), (6, 'storage/os6.jpg', 'exit', 'front'),
(7, 'storage/os7.jpg', 'entry', 'front'), (8, 'storage/os8.jpg', 'entry', 'front'),
(9, 'storage/os9.jpg', 'entry', 'front'), (10, 'storage/os10.jpg', 'entry', 'front'),
(11, 'storage/os11.jpg', 'entry', 'rear'), (12, 'storage/os12.jpg', 'entry', 'left_side'),
(13, 'storage/os13.jpg', 'entry', 'right_side'), (14, 'storage/os14.jpg', 'entry', 'interior'),
(15, 'storage/os15.jpg', 'entry', 'front'), (16, 'storage/os16.jpg', 'exit', 'front'),
(17, 'storage/os17.jpg', 'entry', 'front'), (18, 'storage/os18.jpg', 'entry', 'front'),
(19, 'storage/os19.jpg', 'entry', 'front'), (20, 'storage/os20.jpg', 'entry', 'front');