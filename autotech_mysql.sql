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
