create table project (
    `id` bigint not null auto_increment,
    `name` varchar(100) not null, 
    `description` text, 
    `start_date` date null, 
    `end_date` date null, 
    `status` enum('activo', 'pausado', 'completado') default 'activo',
    `color` varchar(20) default 'primary',
    `created_at` datetime not null,
    `updated_at` timestamp not null default  current_timestamp on update current_timestamp,
    primary key(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;