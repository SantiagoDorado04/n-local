-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 14-05-2024 a las 14:20:04
-- Versión del servidor: 5.7.33
-- Versión de PHP: 8.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `primer`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `agents`
--

CREATE TABLE `agents` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `announcements`
--

CREATE TABLE `announcements` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `announcements_contacts`
--

CREATE TABLE `announcements_contacts` (
  `id` int(10) UNSIGNED NOT NULL,
  `announcement_id` int(11) DEFAULT NULL,
  `contact_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `announcements_forms`
--

CREATE TABLE `announcements_forms` (
  `id` int(10) UNSIGNED NOT NULL,
  `announcement_id` int(10) UNSIGNED DEFAULT NULL,
  `commercial_form_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `announcements_forms_options`
--

CREATE TABLE `announcements_forms_options` (
  `id` int(10) UNSIGNED NOT NULL,
  `announcement_form_id` int(10) UNSIGNED DEFAULT NULL,
  `commercial_question_id` int(10) UNSIGNED DEFAULT NULL,
  `commercial_question_option_id` int(10) UNSIGNED DEFAULT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `answers_form_4`
--

CREATE TABLE `answers_form_4` (
  `id` int(11) NOT NULL,
  `commercial_action_id` int(11) DEFAULT NULL,
  `contact_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `question_16` text,
  `question_17` text,
  `question_18` text,
  `question_20` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `answers_form_5`
--

CREATE TABLE `answers_form_5` (
  `id` int(11) NOT NULL,
  `commercial_action_id` int(11) DEFAULT NULL,
  `contact_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `question_1` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `answers_form_6`
--

CREATE TABLE `answers_form_6` (
  `id` int(11) NOT NULL,
  `commercial_action_id` int(11) DEFAULT NULL,
  `contact_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `question_21` text,
  `question_22` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `answers_form_7`
--

CREATE TABLE `answers_form_7` (
  `id` int(11) NOT NULL,
  `commercial_action_id` int(11) DEFAULT NULL,
  `contact_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `question_23` text,
  `question_24` text,
  `question_25` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `answers_form_8`
--

CREATE TABLE `answers_form_8` (
  `id` int(11) NOT NULL,
  `commercial_action_id` int(11) DEFAULT NULL,
  `contact_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `question_26` text,
  `question_27` text,
  `question_28` text,
  `question_29` text,
  `question_30` text,
  `question_31` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `answers_form_9`
--

CREATE TABLE `answers_form_9` (
  `id` int(11) NOT NULL,
  `commercial_action_id` int(11) DEFAULT NULL,
  `contact_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `question_32` text,
  `question_33` text,
  `question_34` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `answers_form_10`
--

CREATE TABLE `answers_form_10` (
  `id` int(11) NOT NULL,
  `commercial_action_id` int(11) DEFAULT NULL,
  `contact_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `question_35` text,
  `question_36` text,
  `question_37` text,
  `question_38` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `answers_form_11`
--

CREATE TABLE `answers_form_11` (
  `id` int(11) NOT NULL,
  `commercial_action_id` int(11) DEFAULT NULL,
  `contact_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `question_39` text,
  `question_40` text,
  `question_41` text,
  `question_42` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `answers_form_12`
--

CREATE TABLE `answers_form_12` (
  `id` int(11) NOT NULL,
  `commercial_action_id` int(11) DEFAULT NULL,
  `contact_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `question_43` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `answers_form_13`
--

CREATE TABLE `answers_form_13` (
  `id` int(11) NOT NULL,
  `commercial_action_id` int(11) DEFAULT NULL,
  `contact_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `question_44` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `business_models`
--

CREATE TABLE `business_models` (
  `id` int(10) UNSIGNED NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `contact_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `b2b` double DEFAULT NULL,
  `b2c` double DEFAULT NULL,
  `b2g` double DEFAULT NULL,
  `source_income` text COLLATE utf8mb4_unicode_ci,
  `income` double DEFAULT NULL,
  `bills` double DEFAULT NULL,
  `business_plan` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `campaigns`
--

CREATE TABLE `campaigns` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci,
  `send_date` datetime DEFAULT NULL,
  `links` json NOT NULL,
  `send` char(1) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `status` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `campaign_contacts`
--

CREATE TABLE `campaign_contacts` (
  `id` int(11) NOT NULL,
  `contact_id` int(11) DEFAULT NULL,
  `campaign_id` int(11) NOT NULL,
  `opening_date` datetime DEFAULT NULL,
  `links` json DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoryfaqs`
--

CREATE TABLE `categoryfaqs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `categoryfaqs`
--

INSERT INTO `categoryfaqs` (`id`, `title`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Ingreso a la plataforma Usuarios', '<p>Ingreso a la plataforma Usuarios</p>', '2023-04-02 18:08:32', '2023-04-02 18:08:32', '2023-04-02 18:08:00'),
(2, 'Registro Datos Empresariales', '<p>Informaci&oacute;n adicional de la empresa, registro de productos, servicios, modelo de negocio.</p>', '2023-04-03 09:06:05', '2023-04-03 09:06:05', '2023-04-03 09:06:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorysupports`
--

CREATE TABLE `categorysupports` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categorysupports`
--

INSERT INTO `categorysupports` (`id`, `title`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Problemas cuentas de usuarios', '<p>Problemas cuentas de usuarios</p>', '2023-04-03 19:41:33', '2023-04-03 19:41:33', NULL),
(2, 'Problema registro de información de empresas', '<p>Problema registro de informaci&oacute;n de empresas</p>', '2023-04-03 19:41:51', '2023-04-03 19:41:51', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorytutorials`
--

CREATE TABLE `categorytutorials` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categorytutorials`
--

INSERT INTO `categorytutorials` (`id`, `title`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Gestión de usuarios', '<p>Gesti&oacute;n de usuarios</p>', '2023-04-03 19:26:52', '2023-04-03 19:26:52', NULL),
(2, 'Ingreso al sistema', '<p>Ingreso al sistema</p>', '2023-04-03 19:27:07', '2023-04-03 19:27:07', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `challenges`
--

CREATE TABLE `challenges` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `instructions` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `delivery_date` datetime NOT NULL,
  `step_id` bigint(20) UNSIGNED NOT NULL,
  `points` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `reminder_message` text COLLATE utf8mb4_unicode_ci,
  `reminder_message_date` date DEFAULT NULL,
  `reminder_message_mean` text COLLATE utf8mb4_unicode_ci,
  `congratulation_message` text COLLATE utf8mb4_unicode_ci,
  `congratulation_message_date` date DEFAULT NULL,
  `congratulation_message_mean` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `challenges`
--

INSERT INTO `challenges` (`id`, `title`, `instructions`, `delivery_date`, `step_id`, `points`, `created_at`, `updated_at`, `reminder_message`, `reminder_message_date`, `reminder_message_mean`, `congratulation_message`, `congratulation_message_date`, `congratulation_message_mean`) VALUES
(1, 'Rut empresa', 'Lorem ipsum dolor sit amet consectetur adipiscing elit vulputate tristique, purus nunc litora est et iaculis libero interdum nibh erat, dis eleifend imperdiet consequat aliquet proin quisque dictumst. Facilisis magna auctor faucibus felis donec rutrum a mus, montes consequat parturient massa pellentesque torquent suspendisse ut proin, tellus cras elementum porttitor aptent tempus fringilla. Massa conubia mauris fermentum ut vel cras urna vitae, et rutrum in placerat gravida eleifend himenaeos ornare etiam, lobortis mattis integer id sociosqu mi ante.\n\nLibero ultricies pretium accumsan non mi cras congue sociis, sem nisi felis ante magnis tempus fames, mus sed pulvinar conubia malesuada sodales nullam. Interdum vulputate elementum inceptos hac feugiat scelerisque cum sociosqu metus, est eleifend libero eget orci molestie primis massa vel, quis arcu mi dignissim nibh vehicula sed nulla. Ac netus leo sollicitudin habitant facilisi litora, cubilia magna imperdiet metus et malesuada, etiam vitae inceptos ad tempus.', '2024-06-10 00:00:00', 2, NULL, '2024-04-22 21:37:11', '2024-05-02 21:48:09', NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'Camara de comercio', 'Lorem ipsum dolor sit amet consectetur adipiscing elit vulputate tristique, purus nunc litora est et iaculis libero interdum nibh erat, dis eleifend imperdiet consequat aliquet proin quisque dictumst. Facilisis magna auctor faucibus felis donec rutrum a mus, montes consequat parturient massa pellentesque torquent suspendisse ut proin, tellus cras elementum porttitor aptent tempus fringilla. Massa conubia mauris fermentum ut vel cras urna vitae, et rutrum in placerat gravida eleifend himenaeos ornare etiam, lobortis mattis integer id sociosqu mi ante.\n\nLibero ultricies pretium accumsan non mi cras congue sociis, sem nisi felis ante magnis tempus fames, mus sed pulvinar conubia malesuada sodales nullam. Interdum vulputate elementum inceptos hac feugiat scelerisque cum sociosqu metus, est eleifend libero eget orci molestie primis massa vel, quis arcu mi dignissim nibh vehicula sed nulla. Ac netus leo sollicitudin habitant facilisi litora, cubilia magna imperdiet metus et malesuada, etiam vitae inceptos ad tempus.', '2024-06-10 23:55:00', 2, NULL, '2024-05-02 21:47:16', '2024-05-02 21:47:16', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `commercial_actions`
--

CREATE TABLE `commercial_actions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci,
  `description` text COLLATE utf8mb4_unicode_ci,
  `commercial_strategy_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `commercial_forms`
--

CREATE TABLE `commercial_forms` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `commercial_forms`
--

INSERT INTO `commercial_forms` (`id`, `name`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(4, 'Formulario de ejemplo', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '2023-01-13 20:23:47', '2023-01-13 20:23:47', NULL),
(5, 'Convocatoria MinCiencias', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '2023-01-14 07:18:51', '2023-01-14 07:19:02', NULL),
(6, 'Universidad de Latam', 'Universidad de Latam', '2023-02-24 14:38:10', '2023-02-24 14:38:10', NULL),
(7, 'Convocatoria del BID', 'Convocatoria del Banco Interamericano de Desarrollo', '2023-03-06 14:20:27', '2023-03-06 14:20:27', NULL),
(8, 'Registro Empresa', 'Formulario Registro de empresa', '2023-03-23 15:38:54', '2023-03-23 15:38:54', NULL),
(9, 'Información para el donante Tío Hugo', 'Información para el donante Tío Hugo', '2023-04-02 12:50:05', '2023-04-02 12:50:05', NULL),
(10, 'Empresas de impacto', 'Empresas enfocadas en resolver los grandes desafios de la humanidad.', '2023-04-20 11:38:35', '2023-05-09 11:38:57', NULL),
(11, 'Mujeres  que impactan', '\nMujeres que esten desarrollando un proyecto en estapa de ideación o mvp que quieran conocer su mercado, como pueden medir su impacto, tamaño de mercado y oportunidades de crecimiento y mejora en su proyecto.', '2023-05-10 12:40:16', '2023-05-10 12:40:16', NULL),
(12, 'Plan de fidelización de clientes', 'Plan de fidelización de clientes', '2023-06-03 22:49:54', '2023-06-03 22:49:54', NULL),
(13, 'Universidad virtual', 'Universidad virtual', '2024-02-12 15:45:12', '2024-02-12 15:45:12', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `commercial_form_actions`
--

CREATE TABLE `commercial_form_actions` (
  `id` int(10) UNSIGNED NOT NULL,
  `commercial_action_id` int(11) DEFAULT NULL,
  `commercial_form_id` int(11) DEFAULT NULL,
  `token` text COLLATE utf8mb4_unicode_ci,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `commercial_form_options`
--

CREATE TABLE `commercial_form_options` (
  `id` int(10) UNSIGNED NOT NULL,
  `option` text COLLATE utf8mb4_unicode_ci,
  `value` text COLLATE utf8mb4_unicode_ci,
  `commercial_form_question_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `commercial_form_questions`
--

CREATE TABLE `commercial_form_questions` (
  `id` int(10) UNSIGNED NOT NULL,
  `question` text COLLATE utf8mb4_unicode_ci,
  `type` char(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `commercial_form_id` int(10) UNSIGNED DEFAULT NULL,
  `visibility` char(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `commercial_form_questions`
--

INSERT INTO `commercial_form_questions` (`id`, `question`, `type`, `commercial_form_id`, `visibility`, `order`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Bienvenidos a Primer / Welcome to Primer\nSelecciona tu idioma / Choose your languaje', 'po', 1, '1', 1, '2023-01-03 19:25:20', '2023-01-10 03:59:37', NULL),
(2, 'Estas ingresando a primer cloud, para acceder a asesoria sobre fondos de capital de riesgo desde US $200.000 a US $2\'000.000\n\nPor favor selecciona su tipo de empresa:', 'po', 1, '1', 2, '2023-01-03 19:30:09', '2023-01-10 03:59:43', NULL),
(4, 'Escriba el nombre de su Razón Social', 'pa', 1, '1', 3, '2023-01-04 17:25:58', '2023-01-10 04:02:44', NULL),
(5, 'Escriba su número de NIT', 'pa', 1, '1', 4, '2023-01-04 17:26:47', '2023-01-10 04:03:59', NULL),
(6, 'Escriba su correo electrónico', 'pa', 1, '1', 5, '2023-01-04 17:27:08', '2023-01-10 03:26:01', NULL),
(7, 'Por favor, indiqué su nivel de ventas anuales (USD)', 'po', 1, '1', 6, '2023-01-04 17:28:18', '2023-01-10 03:26:04', NULL),
(16, '¿Cuál es su dirección comercial?', 'pa', 4, '1', NULL, '2023-01-13 20:47:26', '2023-01-13 20:47:26', NULL),
(17, 'Cantidad de empleados', 'po', 4, '1', NULL, '2023-01-13 22:08:35', '2023-01-26 14:06:55', NULL),
(18, 'Tipo de empresa', 'po', 4, '1', NULL, '2023-01-13 22:51:57', '2023-01-26 14:06:58', NULL),
(19, 'Actividad economica', 'po', 5, '1', NULL, '2023-01-14 07:20:01', '2023-01-14 07:20:01', NULL),
(20, 'Rango de ventas de año pasado', 'po', 4, '1', NULL, '2023-02-02 21:47:01', '2023-02-02 21:47:01', NULL),
(21, 'Nivel de ventas', 'po', 6, '1', NULL, '2023-02-24 14:39:16', '2023-02-24 14:39:16', NULL),
(22, 'Nombre del Rector', 'pa', 6, '1', NULL, '2023-02-24 14:40:28', '2023-02-24 14:40:28', NULL),
(23, 'Su proyecto beneficia a comunidades rurales o indígenas?', 'po', 7, '1', NULL, '2023-03-06 14:22:48', '2023-03-06 14:22:48', NULL),
(24, 'Cual fue el monto de ventas del año anterior?', 'po', 7, '1', NULL, '2023-03-06 14:23:19', '2023-03-06 14:23:19', NULL),
(25, 'Nombre del representante legal', 'pa', 7, '1', NULL, '2023-03-06 14:23:34', '2023-03-06 14:23:34', NULL),
(26, 'Nivel de ventas anuales (USD)\n', 'po', 8, '1', NULL, '2023-03-23 15:39:33', '2023-03-23 15:45:08', NULL),
(27, '¿Su empresa es propiedad o está liderada por una mujer?\n', 'po', 8, '1', NULL, '2023-03-23 15:39:49', '2023-03-23 15:39:49', NULL),
(28, '¿En cuál etapa se encuentra su producto / servicio?', 'po', 8, '1', NULL, '2023-03-23 15:41:09', '2023-03-23 15:58:54', NULL),
(29, '¿Cuál es el potencial de clientes/beneficiarios que puede alcanzar en 10 años?\n', 'po', 8, '1', NULL, '2023-03-23 15:41:23', '2023-03-23 16:01:50', NULL),
(30, '¿Su solución beneficia a personas de bajos ingresos?\n', 'po', 8, '1', NULL, '2023-03-23 15:41:38', '2023-03-23 16:02:20', NULL),
(31, 'Empresa', 'pa', 8, '1', NULL, '2023-03-24 16:25:33', '2023-03-24 16:25:33', NULL),
(32, 'Estado de la innovación', 'po', 9, '1', NULL, '2023-04-02 12:50:24', '2023-04-02 12:50:24', NULL),
(33, 'Ventas de la innovación del año pasado', 'po', 9, '1', NULL, '2023-04-02 12:50:38', '2023-04-02 12:50:38', NULL),
(34, 'La empresa es privada', 'po', 9, '1', NULL, '2023-04-02 12:50:53', '2023-04-02 12:50:53', NULL),
(35, 'Tamaño de la empresa', 'po', 10, '1', NULL, '2023-04-20 11:40:06', '2023-04-20 11:40:06', NULL),
(36, 'Cantidad de ventas año 2022', 'po', 10, '1', NULL, '2023-04-20 11:42:30', '2023-05-09 11:52:06', NULL),
(37, 'Tipo de clientes ', 'po', 10, '1', NULL, '2023-04-20 11:42:42', '2023-05-09 10:57:51', NULL),
(38, 'Se identifica con alguno de estos sectores ?', 'po', 10, '1', NULL, '2023-05-09 11:01:55', '2023-05-09 11:01:55', NULL),
(39, 'El proyecto es liderado por una mujer ?', 'po', 11, '1', NULL, '2023-05-10 12:41:29', '2023-05-10 12:41:29', NULL),
(40, 'Tienes ventas a la fecha, si tu respues es poner el valor para el ultimo año.', 'pa', 11, '1', NULL, '2023-05-10 12:43:38', '2023-05-10 12:43:38', NULL),
(41, 'Conoces fuentes donde puedes obtener financiación para tu proyecto ?', 'po', 11, '1', NULL, '2023-05-10 12:44:37', '2023-05-10 12:44:37', NULL),
(42, '1000 USD seria un valor que podria apoyar a tu idea de negocio ?', 'po', 11, '1', NULL, '2023-05-10 12:46:25', '2023-05-10 12:46:25', NULL),
(43, 'Cuando fue la ultima compra', 'po', 12, '1', NULL, '2023-06-03 22:50:45', '2023-06-03 22:50:45', NULL),
(44, 'Ventas al año ?', 'po', 13, '1', NULL, '2024-02-12 15:45:38', '2024-02-12 15:45:38', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `commercial_lands`
--

CREATE TABLE `commercial_lands` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `commercial_lands`
--

INSERT INTO `commercial_lands` (`id`, `name`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 'Primer webinar lanzaminto de la inicitiva ', '\n\nEste viernes 16 a las 5 de la tarde, IncubTech, el brazo de innovación y emprendimiento de la Universidad Virtual, abre sus puertas a una emocionante nueva etapa. Nos proponemos transformarnos en una de las aceleradoras más destacadas del país, impulsando el levantamiento de capital tanto a nivel local como internacional.\n\nNuestra visión es generar un crecimiento significativo y potenciar el desarrollo, no solo en operaciones a nivel nacional, sino también a nivel internacional. Aspiramos a ser la semilla de futuras empresas, co-invertidas por fondos globales de renombre, como Y Combinator, Monashees, FJ Labs, Reach Capital, GSV Ventures, NXTP Ventures y Techstars.\"\n\nEspero que sea lo que estás buscando. Si necesitas ajustes adicionales o más detalles, no dudes en proporcionar más información.', '2023-01-02 18:13:27', '2024-02-09 12:54:41', NULL),
(4, 'Marketing de Contenidos', 'Marketing de Contenidos', '2023-06-03 22:34:26', '2023-06-03 22:34:26', NULL),
(5, 'face to face', 'contartar empresas aliadas con el proposito de generar ideas de emprendiemiento ', '2023-08-31 16:07:14', '2023-08-31 16:07:14', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `commercial_strategies`
--

CREATE TABLE `commercial_strategies` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` char(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `commercial_land_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `commercial_strategies`
--

INSERT INTO `commercial_strategies` (`id`, `name`, `description`, `status`, `commercial_land_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(5, 'INVITACIÓN COMUNIDAD ESTUDIANTIL Y AFINES A LA COMUNIDAD', 'Invitaciónes a través de los diferentes canales, con el objetivo de despertar el interes y generar campaña de expectativa.', NULL, 2, '2023-04-20 11:44:58', '2024-02-09 12:58:48', NULL),
(9, 'Descarga de Ebook de valor', 'Descarga de Ebook de valor', NULL, 4, '2023-06-03 22:35:10', '2023-06-03 22:35:10', NULL),
(10, 'Pauta en Youtube ', 'Pauta en Youtube ', NULL, 4, '2023-06-03 22:36:07', '2023-06-03 22:36:07', NULL),
(11, 'base de datos', 'llamar', NULL, 5, '2023-08-31 16:08:16', '2023-08-31 16:08:16', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `company_charges`
--

CREATE TABLE `company_charges` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `company_charges`
--

INSERT INTO `company_charges` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Director Ejecutivo - CEO', '2023-03-22 16:42:55', '2023-03-22 16:42:55', NULL),
(2, 'Director de Operaciones - COO', '2023-03-22 16:42:55', '2023-03-22 16:42:55', NULL),
(3, 'Director Comercial - CSO', '2023-03-22 16:42:55', '2023-03-22 16:42:55', NULL),
(4, 'Director de Marketing - CMO', '2023-03-22 16:42:55', '2023-03-22 16:42:55', NULL),
(5, 'Director de Recursos Humanos - CHRO', '2023-03-22 16:42:56', '2023-03-22 16:42:56', NULL),
(6, 'Customer Success - CS', '2023-03-22 16:42:56', '2023-03-22 16:42:56', NULL),
(7, 'Director Financiero - CFO', '2023-03-22 16:42:56', '2023-03-22 16:42:56', NULL),
(8, 'Líder de innovación - CTI', '2023-04-20 13:30:53', '2023-04-20 13:31:08', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `company_types`
--

CREATE TABLE `company_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `company_types`
--

INSERT INTO `company_types` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Pública', '2023-03-22 11:12:54', '2023-03-22 11:12:54', NULL),
(2, 'Privada', '2023-03-22 11:13:03', '2023-03-22 11:13:03', NULL),
(3, 'Pequeña', '2023-03-22 11:13:09', '2023-03-22 11:13:09', NULL),
(4, 'Micro', '2023-03-22 11:13:15', '2023-03-22 11:13:15', NULL),
(5, 'Pyme', '2023-03-22 11:13:20', '2023-03-22 11:13:20', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contacts`
--

CREATE TABLE `contacts` (
  `id` int(10) UNSIGNED NOT NULL,
  `nit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `main_sector` int(11) DEFAULT NULL,
  `secondary_sector` int(11) DEFAULT NULL,
  `company_type_id` int(11) DEFAULT NULL,
  `commercial_action_id` int(11) DEFAULT NULL,
  `form_action_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `address` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `whatsapp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_person_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_person_email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `leader_name` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `leader_position` int(11) DEFAULT NULL,
  `leader_email` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `leader_phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `leader_gender` char(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `leader_age` int(11) DEFAULT NULL,
  `storage` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rate` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT 'sin calificar',
  `commercial_form_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `points` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `contacts`
--

INSERT INTO `contacts` (`id`, `nit`, `name`, `main_sector`, `secondary_sector`, `company_type_id`, `commercial_action_id`, `form_action_id`, `created_at`, `updated_at`, `deleted_at`, `address`, `city_id`, `phone`, `email`, `whatsapp`, `website`, `contact_person_name`, `contact_person_email`, `leader_name`, `leader_position`, `leader_email`, `leader_phone`, `leader_gender`, `leader_age`, `storage`, `rate`, `commercial_form_id`, `user_id`, `points`) VALUES
(1, '1004217506', 'Herney', NULL, NULL, NULL, NULL, NULL, '2024-04-18 20:24:28', '2024-04-18 20:24:28', NULL, NULL, NULL, '3155163134', 'herney@mail.com', NULL, NULL, 'Herney', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'form', 'sin calificar', NULL, 54, 0),
(2, '59837294', 'Maria', NULL, NULL, NULL, NULL, NULL, '2024-04-19 20:57:58', '2024-05-08 16:27:21', NULL, NULL, NULL, '3175202825', 'danielcriollo9706@gmail.com', NULL, NULL, 'Maria', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'form', 'sin calificar', NULL, 55, 30),
(3, '12345677', 'Felipe', NULL, NULL, NULL, NULL, NULL, '2024-04-19 21:18:20', '2024-04-19 21:18:20', NULL, NULL, NULL, '3175202825', 'felix@mail.com', NULL, NULL, 'Felipe', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'form', 'sin calificar', NULL, 56, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contacts_assigned_forms`
--

CREATE TABLE `contacts_assigned_forms` (
  `id` int(10) UNSIGNED NOT NULL,
  `contact_id` int(11) DEFAULT NULL,
  `commercial_form_action_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contacts_attachments`
--

CREATE TABLE `contacts_attachments` (
  `id` int(10) UNSIGNED NOT NULL,
  `url` text COLLATE utf8mb4_unicode_ci,
  `contact_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contacts_challenges`
--

CREATE TABLE `contacts_challenges` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `feedback` text COLLATE utf8mb4_unicode_ci,
  `challenge_id` bigint(20) UNSIGNED NOT NULL,
  `contact_id` int(11) DEFAULT NULL,
  `approved` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `contacts_challenges`
--

INSERT INTO `contacts_challenges` (`id`, `text`, `file`, `feedback`, `challenge_id`, `contact_id`, `approved`, `created_at`, `updated_at`) VALUES
(5, 'Mi archivo', 'uploads/TH9izbtNwWwmyvY62EQOJ4bceCp6ZY7RCqKXiNSt.pdf', 'El archivo es correcto', 1, 2, 1, '2024-05-03 03:43:44', '2024-05-06 05:43:01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contacts_information_forms`
--

CREATE TABLE `contacts_information_forms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `contact_id` bigint(20) UNSIGNED NOT NULL,
  `information_form_id` bigint(20) UNSIGNED NOT NULL,
  `date_completed` datetime NOT NULL,
  `approved` tinyint(4) DEFAULT NULL,
  `feedback` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `contacts_information_forms`
--

INSERT INTO `contacts_information_forms` (`id`, `contact_id`, `information_form_id`, `date_completed`, `approved`, `feedback`, `created_at`, `updated_at`) VALUES
(8, 2, 4, '2024-05-07 17:55:08', 1, 'Diligenciamiento correcto', '2024-05-07 22:55:08', '2024-05-08 15:29:26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contacts_mentoring`
--

CREATE TABLE `contacts_mentoring` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `contact_id` bigint(20) UNSIGNED NOT NULL,
  `step_id` bigint(20) UNSIGNED NOT NULL,
  `mentor_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `start` time NOT NULL,
  `end` time NOT NULL,
  `attended` tinyint(4) DEFAULT NULL,
  `feedback` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `contacts_mentoring`
--

INSERT INTO `contacts_mentoring` (`id`, `contact_id`, `step_id`, `mentor_id`, `date`, `start`, `end`, `attended`, `feedback`, `created_at`, `updated_at`) VALUES
(34, 3, 4, 1, '2024-05-07', '08:00:00', '08:30:00', 1, 'Feedback here', '2024-05-06 13:07:10', '2024-05-08 16:17:59'),
(35, 2, 4, 1, '2024-05-07', '08:30:00', '09:00:00', 1, 'Llego tarde', '2024-05-08 16:26:00', '2024-05-08 16:28:19');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contacts_points_details`
--

CREATE TABLE `contacts_points_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `detail` text COLLATE utf8mb4_unicode_ci,
  `points` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `contacts_points_details`
--

INSERT INTO `contacts_points_details` (`id`, `detail`, `points`, `date`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Se te han asignado +10 por el registro del formulario \"Recolección de información\"', 10, '2024-05-08 10:00:19', '2024-05-08 15:00:19', '2024-05-08 15:00:19', NULL),
(2, 'Se te han asignado +10 por el registro del formulario \"Recolección de información\"', 10, '2024-05-08 10:28:46', '2024-05-08 15:28:46', '2024-05-08 15:28:46', NULL),
(3, 'Se te han asignado +10 por por la asistencia a mentoria con \"Daniel\"', 10, '2024-05-08 11:27:21', '2024-05-08 16:27:21', '2024-05-08 16:27:21', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contacts_proposals`
--

CREATE TABLE `contacts_proposals` (
  `id` int(10) UNSIGNED NOT NULL,
  `proposal_template_id` int(11) DEFAULT NULL,
  `contact_id` int(11) DEFAULT NULL,
  `url_file` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `answers` json DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contacts_schedules`
--

CREATE TABLE `contacts_schedules` (
  `id` int(10) UNSIGNED NOT NULL,
  `contact_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `assignment_date` datetime DEFAULT NULL,
  `priority` char(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_to_contact` date DEFAULT NULL,
  `time_to_contact` time DEFAULT NULL,
  `observations_contact` text COLLATE utf8mb4_unicode_ci,
  `date_contact` date DEFAULT NULL,
  `time_contact` time DEFAULT NULL,
  `observations_user` text COLLATE utf8mb4_unicode_ci,
  `status` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT 'assigned',
  `assigned_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contacts_stages`
--

CREATE TABLE `contacts_stages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `contact_id` bigint(20) UNSIGNED NOT NULL,
  `stage_id` bigint(20) UNSIGNED NOT NULL,
  `approved` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `contacts_stages`
--

INSERT INTO `contacts_stages` (`id`, `contact_id`, `stage_id`, `approved`, `created_at`, `updated_at`) VALUES
(1, 2, 6, 1, '2024-04-20 01:58:00', '2024-04-20 21:01:06'),
(2, 3, 6, 1, '2024-04-20 02:18:22', '2024-05-06 13:05:25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contracts_templates`
--

CREATE TABLE `contracts_templates` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `url_file` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `courses`
--

CREATE TABLE `courses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `first` tinyint(1) NOT NULL,
  `previous_course` bigint(20) UNSIGNED DEFAULT NULL,
  `next_course` bigint(20) UNSIGNED DEFAULT NULL,
  `duration` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `step_id` int(11) NOT NULL,
  `points` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `reminder_message` text COLLATE utf8mb4_unicode_ci,
  `reminder_message_date` date DEFAULT NULL,
  `reminder_message_mean` text COLLATE utf8mb4_unicode_ci,
  `congratulation_message` text COLLATE utf8mb4_unicode_ci,
  `congratulation_message_date` date DEFAULT NULL,
  `congratulation_message_mean` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `courses`
--

INSERT INTO `courses` (`id`, `name`, `description`, `first`, `previous_course`, `next_course`, `duration`, `start_date`, `end_date`, `step_id`, `points`, `created_at`, `updated_at`, `reminder_message`, `reminder_message_date`, `reminder_message_mean`, `congratulation_message`, `congratulation_message_date`, `congratulation_message_mean`) VALUES
(1, 'Habiliades Blandas', 'Lorem ipsum dolor sit amet consectetur adipiscing elit nullam, non odio et aliquet facilisis gravida taciti, sagittis ultricies tempor torquent massa venenatis volutpat. Diam suspendisse pellentesque ultricies augue fringilla rhoncus sem, eros feugiat turpis etiam sociosqu justo fusce, hendrerit risus odio quis hac auctor. Himenaeos vulputate justo rhoncus pellentesque sed duis placerat erat vel, nisi potenti lobortis sociis massa ante malesuada blandit, euismod consequat proin hac dapibus diam congue cubilia.\n\nVelit imperdiet metus per leo ante etiam, elementum fermentum viverra eu suspendisse auctor, blandit tempus ornare vivamus massa mi, fusce congue scelerisque nunc rutrum. Per sagittis quam viverra velit arcu placerat hac, erat fringilla cubilia sociosqu vestibulum lectus tellus blandit, mus egestas mattis aliquam tincidunt cursus. Auctor egestas lobortis eget rutrum porta tempus nascetur libero leo, neque magna massa cras montes sem scelerisque himenaeos, eros sollicitudin quam penatibus nibh ad risus ornare.', 1, NULL, NULL, 1, '2024-05-10', '2024-05-12', 1, NULL, '2024-04-15 21:07:33', '2024-04-15 21:07:33', NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'Marketing Digital', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 1, NULL, NULL, 1, '2024-04-23', '2024-04-24', 2, NULL, '2024-04-16 20:38:43', '2024-04-16 20:38:43', NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'Habilidades Blandas', 'Lorem ipsum dolor sit amet consectetur adipiscing elit placerat, tristique in suscipit proin risus ante sociosqu parturient, scelerisque sagittis per gravida nec aliquet conubia. Mattis maecenas urna massa eleifend nisi lacinia varius malesuada erat, dignissim senectus dapibus eu tincidunt purus pellentesque phasellus. Dui tortor nam rhoncus conubia ligula dictumst tristique cubilia porta, nulla augue ac nascetur dictum cursus hendrerit.\n\nEget nostra convallis erat cubilia iaculis varius nisl velit aptent, mollis rhoncus ad ultricies at donec laoreet blandit. Tempor neque est cursus gravida vestibulum mollis mus condimentum aptent cubilia hac, nascetur proin parturient dapibus blandit felis scelerisque fames augue. Cras suscipit augue sem hac velit, lectus porttitor non malesuada purus nullam, eu praesent torquent urna.', 1, NULL, NULL, 60, '2024-05-06', '2024-05-07', 5, NULL, '2024-05-06 14:47:13', '2024-05-06 14:47:13', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `data_rows`
--

CREATE TABLE `data_rows` (
  `id` int(10) UNSIGNED NOT NULL,
  `data_type_id` int(10) UNSIGNED NOT NULL,
  `field` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `required` tinyint(1) NOT NULL DEFAULT '0',
  `browse` tinyint(1) NOT NULL DEFAULT '1',
  `read` tinyint(1) NOT NULL DEFAULT '1',
  `edit` tinyint(1) NOT NULL DEFAULT '1',
  `add` tinyint(1) NOT NULL DEFAULT '1',
  `delete` tinyint(1) NOT NULL DEFAULT '1',
  `details` text COLLATE utf8mb4_unicode_ci,
  `order` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `data_rows`
--

INSERT INTO `data_rows` (`id`, `data_type_id`, `field`, `type`, `display_name`, `required`, `browse`, `read`, `edit`, `add`, `delete`, `details`, `order`) VALUES
(1, 1, 'id', 'number', 'ID', 1, 1, 1, 0, 0, 0, '{}', 1),
(2, 1, 'name', 'text', 'Nombre', 1, 1, 1, 1, 1, 1, '{}', 3),
(3, 1, 'email', 'text', 'Correo electrónico', 1, 1, 1, 1, 1, 1, '{}', 4),
(4, 1, 'password', 'password', 'Contraseña', 1, 0, 0, 1, 1, 0, '{}', 5),
(5, 1, 'remember_token', 'text', 'Remember Token', 0, 0, 0, 0, 0, 0, '{}', 13),
(6, 1, 'created_at', 'timestamp', 'Creación', 0, 1, 1, 0, 0, 0, '{}', 10),
(7, 1, 'updated_at', 'timestamp', 'Modificación', 0, 1, 1, 0, 0, 0, '{}', 11),
(8, 1, 'avatar', 'image', 'Avatar', 0, 1, 1, 1, 1, 1, '{}', 2),
(9, 1, 'user_belongsto_role_relationship', 'relationship', 'Rol', 0, 1, 1, 1, 1, 0, '{\"model\":\"TCG\\\\Voyager\\\\Models\\\\Role\",\"table\":\"roles\",\"type\":\"belongsTo\",\"column\":\"role_id\",\"key\":\"id\",\"label\":\"display_name\",\"pivot_table\":\"roles\",\"pivot\":\"0\",\"taggable\":\"0\"}', 7),
(10, 1, 'user_belongstomany_role_relationship', 'relationship', 'Roles', 0, 1, 1, 1, 1, 0, '{\"model\":\"TCG\\\\Voyager\\\\Models\\\\Role\",\"table\":\"roles\",\"type\":\"belongsToMany\",\"column\":\"id\",\"key\":\"id\",\"label\":\"display_name\",\"pivot_table\":\"user_roles\",\"pivot\":\"1\",\"taggable\":\"0\"}', 8),
(11, 1, 'settings', 'hidden', 'Idioma', 0, 0, 0, 0, 0, 0, '{}', 9),
(12, 2, 'id', 'number', 'ID', 1, 1, 1, 0, 0, 0, '{}', 1),
(13, 2, 'name', 'text', 'Nombre', 1, 1, 1, 1, 1, 1, '{}', 2),
(14, 2, 'created_at', 'timestamp', 'Creación', 0, 1, 1, 0, 0, 0, '{}', 3),
(15, 2, 'updated_at', 'timestamp', 'Modificación', 0, 1, 1, 0, 0, 0, '{}', 4),
(16, 3, 'id', 'number', 'ID', 1, 1, 1, 0, 0, 0, '{}', 1),
(17, 3, 'name', 'text', 'Nombre', 1, 1, 1, 1, 1, 1, '{}', 2),
(18, 3, 'created_at', 'timestamp', 'Creación', 0, 1, 1, 0, 0, 0, '{}', 4),
(19, 3, 'updated_at', 'timestamp', 'Modificación', 0, 1, 1, 0, 0, 0, '{}', 5),
(20, 3, 'display_name', 'text', 'Display Name', 1, 1, 1, 1, 1, 1, '{}', 3),
(21, 1, 'role_id', 'select_dropdown', 'Rol', 0, 1, 1, 1, 1, 1, '{}', 6),
(22, 1, 'email_verified_at', 'timestamp', 'Email Verified At', 0, 0, 0, 0, 0, 0, '{}', 12),
(23, 4, 'id', 'text', 'ID', 1, 1, 1, 0, 0, 0, '{}', 1),
(24, 4, 'key', 'text', 'Key', 1, 1, 1, 1, 1, 1, '{}', 2),
(25, 4, 'table_name', 'text', 'Tabla', 0, 1, 1, 1, 1, 1, '{}', 3),
(26, 4, 'created_at', 'timestamp', 'Fecha de creación', 0, 1, 1, 0, 0, 0, '{}', 4),
(27, 4, 'updated_at', 'timestamp', 'Fecha de modificación', 0, 1, 1, 0, 0, 0, '{}', 5),
(28, 5, 'id', 'text', 'ID', 1, 1, 1, 0, 0, 0, '{}', 1),
(30, 5, 'created_at', 'timestamp', 'Creación', 0, 0, 1, 0, 0, 0, '{}', 4),
(31, 5, 'updated_at', 'timestamp', 'Updated At', 0, 0, 1, 0, 0, 0, '{}', 5),
(32, 5, 'deleted_at', 'timestamp', 'Deleted At', 0, 0, 0, 0, 0, 0, '{}', 6),
(33, 6, 'id', 'text', 'ID', 1, 1, 1, 0, 0, 0, '{}', 1),
(34, 6, 'user_id', 'select_dropdown', 'Usuario', 0, 1, 1, 1, 1, 1, '{}', 2),
(35, 6, 'color', 'color', 'Color', 0, 1, 1, 1, 1, 1, '{}', 4),
(36, 6, 'agent_belongsto_user_relationship', 'relationship', 'Usuario', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\Models\\\\User\",\"table\":\"users\",\"type\":\"belongsTo\",\"column\":\"user_id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"agents\",\"pivot\":\"0\",\"taggable\":\"0\"}', 3),
(37, 5, 'description', 'rich_text_box', 'Descripción', 0, 1, 1, 1, 1, 1, '{}', 3),
(38, 5, 'title', 'text', 'Titulo', 0, 1, 1, 1, 1, 1, '{}', 2),
(39, 7, 'id', 'text', 'ID', 1, 1, 1, 0, 0, 0, '{}', 1),
(41, 7, 'created_at', 'timestamp', 'Fecha de creación', 0, 1, 1, 0, 0, 0, '{}', 4),
(42, 7, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 5),
(43, 7, 'deleted_at', 'timestamp', 'Deleted At', 0, 0, 0, 0, 0, 0, '{}', 6),
(44, 7, 'description', 'rich_text_box', 'Descripción', 0, 1, 1, 1, 1, 1, '{}', 3),
(45, 7, 'name', 'text', 'Name', 0, 1, 1, 1, 1, 1, '{}', 2),
(81, 19, 'id', 'text', 'Id', 1, 1, 1, 0, 0, 0, '{}', 1),
(82, 19, 'regulations', 'rich_text_box', 'Regulations', 0, 0, 1, 1, 1, 1, '{}', 3),
(83, 19, 'market', 'rich_text_box', 'Market', 0, 0, 1, 1, 1, 1, '{}', 4),
(84, 19, 'units_economics', 'rich_text_box', 'Units Economics', 0, 0, 1, 1, 1, 1, '{}', 5),
(85, 19, 'traction', 'rich_text_box', 'Traction', 0, 0, 1, 1, 1, 1, '{}', 6),
(86, 19, 'created_at', 'timestamp', 'Created At', 0, 0, 1, 0, 0, 1, '{}', 7),
(87, 19, 'updated_at', 'timestamp', 'Updated At', 0, 0, 1, 0, 0, 0, '{}', 8),
(88, 19, 'deleted_at', 'timestamp', 'Deleted At', 0, 0, 1, 0, 0, 1, '{}', 9),
(89, 19, 'project_id', 'text', 'Project Id', 1, 1, 1, 1, 1, 1, '{}', 10),
(90, 19, 'scaling_belongsto_project_relationship', 'relationship', 'projects', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\Models\\\\Project\",\"table\":\"projects\",\"type\":\"belongsTo\",\"column\":\"project_id\",\"key\":\"id\",\"label\":\"title\",\"pivot_table\":\"agents\",\"pivot\":\"0\",\"taggable\":\"0\"}', 2),
(91, 20, 'id', 'text', 'Id', 1, 1, 1, 0, 0, 0, '{}', 1),
(92, 20, 'metrics', 'rich_text_box', 'Metrics', 0, 0, 1, 1, 1, 1, '{}', 3),
(93, 20, 'data_collection', 'rich_text_box', 'Data Collection', 0, 0, 1, 1, 1, 1, '{}', 4),
(94, 20, 'evidence', 'rich_text_box', 'Evidence', 0, 0, 1, 1, 1, 1, '{}', 5),
(95, 20, 'created_at', 'timestamp', 'Created At', 0, 0, 1, 0, 0, 1, '{}', 6),
(96, 20, 'updated_at', 'timestamp', 'Updated At', 0, 0, 1, 0, 0, 0, '{}', 7),
(97, 20, 'deleted_at', 'timestamp', 'Deleted At', 0, 0, 1, 0, 0, 1, '{}', 8),
(98, 20, 'project_id', 'text', 'Project Id', 0, 1, 1, 1, 1, 1, '{}', 9),
(99, 20, 'impact_belongsto_project_relationship', 'relationship', 'projects', 1, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\Models\\\\Project\",\"table\":\"projects\",\"type\":\"belongsTo\",\"column\":\"project_id\",\"key\":\"id\",\"label\":\"title\",\"pivot_table\":\"agents\",\"pivot\":\"0\",\"taggable\":\"0\"}', 2),
(100, 20, 'adjunto1', 'file', 'Adjunto No. 1', 0, 1, 1, 1, 1, 1, '{}', 9),
(101, 20, 'adjunto2', 'file', 'Adjunto No. 2', 0, 1, 1, 1, 1, 1, '{}', 10),
(102, 21, 'id', 'text', 'ID', 1, 1, 1, 0, 0, 0, '{}', 1),
(103, 21, 'name', 'text', 'Nombre', 0, 1, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"unique:company_types,name\"}}', 2),
(104, 21, 'created_at', 'timestamp', 'Creación', 0, 0, 1, 0, 0, 0, '{}', 3),
(105, 21, 'updated_at', 'timestamp', 'Modificación', 0, 0, 1, 0, 0, 0, '{}', 4),
(106, 21, 'deleted_at', 'timestamp', 'Deleted At', 0, 0, 0, 0, 0, 0, '{}', 5),
(107, 22, 'id', 'text', 'ID', 1, 1, 1, 0, 0, 0, '{}', 1),
(108, 22, 'name', 'text', 'Nombre', 0, 1, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"unique:economic_sectors,name\"}}', 2),
(109, 22, 'created_at', 'timestamp', 'Creación', 0, 0, 1, 0, 0, 0, '{}', 3),
(110, 22, 'updated_at', 'timestamp', 'Modificación', 0, 0, 1, 0, 0, 0, '{}', 4),
(111, 22, 'deleted_at', 'timestamp', 'Deleted At', 0, 0, 0, 0, 0, 0, '{}', 5),
(112, 23, 'id', 'text', 'ID', 1, 1, 1, 0, 0, 0, '{}', 1),
(113, 23, 'name', 'text', 'Nombre', 0, 1, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"unique:company_charges,name\"}}', 2),
(114, 23, 'created_at', 'timestamp', 'Creación', 0, 0, 1, 0, 0, 0, '{}', 3),
(115, 23, 'updated_at', 'timestamp', 'Modificación', 0, 0, 1, 0, 0, 0, '{}', 4),
(116, 23, 'deleted_at', 'timestamp', 'Deleted At', 0, 0, 0, 0, 0, 0, '{}', 5),
(117, 24, 'id', 'text', 'ID', 1, 1, 1, 0, 0, 0, '{}', 1),
(118, 24, 'name', 'text', 'Nombre', 1, 1, 1, 1, 1, 1, '{}', 2),
(119, 24, 'created_at', 'timestamp', 'Creación', 0, 0, 1, 0, 0, 0, '{}', 3),
(120, 24, 'updated_at', 'timestamp', 'Modificación', 0, 0, 1, 0, 0, 0, '{}', 4),
(121, 24, 'deleted_at', 'timestamp', 'Deleted At', 0, 0, 0, 0, 0, 0, '{}', 5),
(122, 25, 'id', 'text', 'ID', 1, 1, 1, 0, 0, 0, '{}', 1),
(123, 25, 'name', 'text', 'Nombre', 0, 1, 1, 1, 1, 1, '{}', 2),
(124, 25, 'created_at', 'timestamp', 'Creación', 0, 0, 1, 0, 0, 0, '{}', 3),
(125, 25, 'updated_at', 'timestamp', 'Modificación', 0, 0, 1, 0, 0, 0, '{}', 4),
(126, 25, 'deleted_at', 'timestamp', 'Deleted At', 0, 0, 0, 0, 0, 0, '{}', 5),
(127, 29, 'id', 'number', 'Id', 1, 1, 1, 0, 0, 0, '{}', 1),
(128, 29, 'title', 'text', 'Titulo', 1, 1, 1, 1, 1, 1, '{}', 2),
(129, 29, 'description', 'rich_text_box', 'Descripción', 0, 1, 1, 1, 1, 1, '{}', 3),
(130, 29, 'created_at', 'timestamp', 'Creado', 1, 0, 1, 1, 0, 1, '{}', 4),
(131, 29, 'updated_at', 'timestamp', 'Actualizado', 0, 0, 1, 0, 0, 0, '{}', 5),
(132, 29, 'deleted_at', 'timestamp', 'Eliminado', 0, 0, 1, 0, 0, 0, '{}', 6),
(155, 31, 'id', 'text', 'Id', 1, 1, 1, 0, 0, 0, '{}', 1),
(156, 31, 'title', 'text', 'Titulo', 1, 1, 1, 1, 1, 1, '{}', 2),
(157, 31, 'description', 'rich_text_box', 'Descripción', 0, 1, 1, 1, 1, 1, '{}', 3),
(158, 31, 'created_at', 'timestamp', 'Created At', 0, 0, 1, 0, 0, 1, '{}', 4),
(159, 31, 'updated_at', 'timestamp', 'Updated At', 0, 0, 1, 0, 0, 0, '{}', 5),
(160, 31, 'deleted_at', 'timestamp', 'Deleted At', 0, 0, 1, 0, 0, 1, '{}', 6),
(161, 32, 'id', 'text', 'Id', 1, 1, 1, 0, 0, 0, '{}', 1),
(162, 32, 'title', 'text', 'Titulo', 1, 1, 1, 1, 1, 1, '{}', 2),
(163, 32, 'slug', 'text', 'Slug', 1, 1, 1, 1, 1, 1, '{\"slugify\":{\"origin\":\"title\",\"forceUpdate\":true}}', 3),
(164, 32, 'description', 'rich_text_box', 'Descripción', 0, 0, 1, 1, 1, 1, '{}', 5),
(165, 32, 'category_tutorials_id', 'text', 'Categoría de tutoriales', 1, 1, 1, 1, 1, 1, '{}', 7),
(166, 32, 'create_user_id', 'text', 'Usuario creador', 1, 0, 1, 1, 1, 1, '{}', 9),
(167, 32, 'update_user_id', 'text', 'Usuario modificador', 0, 0, 1, 1, 1, 1, '{}', 11),
(168, 32, 'state', 'radio_btn', 'Estado', 1, 1, 1, 1, 1, 1, '{\"default\":\"borrador\",\"options\":{\"borrador\":\"Borrador\",\"revision\":\"Revisi\\u00f3n\",\"aprobado\":\"Aprobado\",\"publicado\":\"Publicado\"}}', 12),
(169, 32, 'attached', 'file', 'Adjunto', 0, 0, 1, 1, 1, 1, '{}', 13),
(170, 32, 'embed', 'rich_text_box', 'Embed', 0, 1, 1, 1, 1, 1, '{}', 4),
(171, 32, 'created_at', 'timestamp', 'Created At', 0, 0, 1, 0, 0, 1, '{}', 14),
(172, 32, 'updated_at', 'timestamp', 'Updated At', 0, 0, 1, 0, 0, 0, '{}', 15),
(173, 32, 'deleted_at', 'timestamp', 'Deleted At', 0, 0, 1, 0, 0, 1, '{}', 16),
(174, 32, 'tutorial_belongsto_categorytutorial_relationship', 'relationship', 'Categoría de tutoriales', 1, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\Categorytutorial\",\"table\":\"categorytutorials\",\"type\":\"belongsTo\",\"column\":\"category_tutorials_id\",\"key\":\"id\",\"label\":\"title\",\"pivot_table\":\"agents\",\"pivot\":\"0\",\"taggable\":\"0\"}', 6),
(175, 32, 'tutorial_belongsto_user_relationship', 'relationship', 'Usuario creador', 1, 1, 1, 1, 1, 1, '{\"model\":\"TCG\\\\Voyager\\\\Models\\\\User\",\"table\":\"users\",\"type\":\"belongsTo\",\"column\":\"create_user_id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"agents\",\"pivot\":\"0\",\"taggable\":\"0\"}', 8),
(176, 32, 'tutorial_belongsto_user_relationship_1', 'relationship', 'Usuario modificador', 1, 0, 1, 1, 1, 1, '{\"model\":\"TCG\\\\Voyager\\\\Models\\\\User\",\"table\":\"users\",\"type\":\"belongsTo\",\"column\":\"update_user_id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"agents\",\"pivot\":\"0\",\"taggable\":\"0\"}', 10),
(177, 33, 'id', 'text', 'Id', 1, 1, 1, 0, 0, 0, '{}', 1),
(178, 33, 'title', 'text', 'Titulo', 1, 1, 1, 1, 1, 1, '{}', 2),
(179, 33, 'description', 'rich_text_box', 'Descripción', 0, 0, 1, 1, 1, 1, '{}', 3),
(180, 33, 'created_at', 'timestamp', 'Created At', 0, 0, 1, 0, 0, 1, '{}', 4),
(181, 33, 'updated_at', 'timestamp', 'Updated At', 0, 0, 1, 0, 0, 0, '{}', 5),
(182, 33, 'deleted_at', 'timestamp', 'Deleted At', 0, 0, 1, 0, 0, 0, '{}', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `data_types`
--

CREATE TABLE `data_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name_singular` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name_plural` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `policy_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `controller` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `generate_permissions` tinyint(1) NOT NULL DEFAULT '0',
  `server_side` tinyint(4) NOT NULL DEFAULT '0',
  `details` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `data_types`
--

INSERT INTO `data_types` (`id`, `name`, `slug`, `display_name_singular`, `display_name_plural`, `icon`, `model_name`, `policy_name`, `controller`, `description`, `generate_permissions`, `server_side`, `details`, `created_at`, `updated_at`) VALUES
(1, 'users', 'users', 'Usuario', 'Usuarios', 'voyager-person', 'TCG\\Voyager\\Models\\User', 'TCG\\Voyager\\Policies\\UserPolicy', 'TCG\\Voyager\\Http\\Controllers\\VoyagerUserController', NULL, 1, 1, '{\"order_column\":\"id\",\"order_display_column\":\"name\",\"order_direction\":\"asc\",\"default_search_key\":\"name\",\"scope\":null}', '2022-12-29 08:33:07', '2022-12-29 08:58:48'),
(2, 'menus', 'menus', 'Menú', 'Menús', 'voyager-list', 'TCG\\Voyager\\Models\\Menu', NULL, NULL, NULL, 1, 1, '{\"order_column\":\"id\",\"order_display_column\":\"name\",\"order_direction\":\"asc\",\"default_search_key\":\"name\",\"scope\":null}', '2022-12-29 08:33:07', '2022-12-29 09:00:40'),
(3, 'roles', 'roles', 'Rol', 'Roles', 'voyager-lock', 'TCG\\Voyager\\Models\\Role', NULL, 'TCG\\Voyager\\Http\\Controllers\\VoyagerRoleController', NULL, 1, 1, '{\"order_column\":\"id\",\"order_display_column\":\"name\",\"order_direction\":\"asc\",\"default_search_key\":\"name\",\"scope\":null}', '2022-12-29 08:33:07', '2022-12-29 09:00:01'),
(4, 'permissions', 'permissions', 'Permiso', 'Permisos', 'voyager-key', 'TCG\\Voyager\\Models\\Permission', NULL, NULL, NULL, 1, 0, '{\"order_column\":\"id\",\"order_display_column\":\"table_name\",\"order_direction\":\"asc\",\"default_search_key\":\"table_name\",\"scope\":null}', '2023-01-24 16:26:18', '2023-02-16 19:29:10'),
(5, 'tasks_types', 'tasks-types', 'Tarea', 'Tareas', 'fa fa-tasks', 'App\\TasksType', NULL, NULL, NULL, 1, 1, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2023-02-06 19:11:22', '2023-04-01 23:26:19'),
(6, 'agents', 'agents', 'Agente', 'Agentes', 'voyager-person', 'App\\Agent', NULL, NULL, NULL, 1, 1, '{\"order_column\":\"id\",\"order_display_column\":\"id\",\"order_direction\":\"asc\",\"default_search_key\":\"id\",\"scope\":null}', '2023-02-06 19:38:39', '2023-02-06 19:39:56'),
(7, 'memberships', 'memberships', 'Membresia', 'Membresias', 'voyager-credit-cards', 'App\\Membership', NULL, NULL, NULL, 1, 1, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2023-03-04 13:11:00', '2023-03-06 08:34:12'),
(15, 'project', 'project', 'Project', 'Projects', 'voyager-certificate', 'App\\Models\\Project', NULL, NULL, NULL, 1, 0, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null}', '2023-03-14 06:59:51', '2023-03-14 06:59:51'),
(19, 'scalings', 'scalings', 'Scaling', 'Scalings', 'voyager-params', 'App\\Models\\Scaling', NULL, NULL, NULL, 1, 0, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2023-03-14 07:26:24', '2023-03-14 07:27:26'),
(20, 'impacts', 'impacts', 'Impact', 'Impacts', 'voyager-bubble-hear', 'App\\Models\\Impact', NULL, NULL, NULL, 1, 0, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2023-03-14 07:30:13', '2023-03-14 11:25:57'),
(21, 'company_types', 'company-types', 'Tipo de empresa', 'Tipos de empresa', 'voyager-list', 'App\\CompanyType', NULL, NULL, NULL, 1, 1, '{\"order_column\":\"id\",\"order_display_column\":\"name\",\"order_direction\":\"asc\",\"default_search_key\":\"name\",\"scope\":null}', '2023-03-22 11:11:08', '2023-04-01 23:22:14'),
(22, 'economic_sectors', 'economic-sectors', 'Sector económico', 'Sectores económicos', 'voyager-list', 'App\\EconomicSector', NULL, NULL, NULL, 1, 1, '{\"order_column\":\"id\",\"order_display_column\":\"name\",\"order_direction\":\"asc\",\"default_search_key\":\"name\",\"scope\":null}', '2023-03-22 11:23:12', '2023-04-01 23:23:11'),
(23, 'company_charges', 'company-charges', 'Cargo Empresa', 'Cargos Empresas', 'voyager-list', 'App\\CompanyCharge', NULL, NULL, NULL, 1, 1, '{\"order_column\":\"id\",\"order_display_column\":\"name\",\"order_direction\":\"asc\",\"default_search_key\":\"name\",\"scope\":null}', '2023-03-22 11:28:59', '2023-04-01 23:24:02'),
(24, 'development_levels', 'development-levels', 'Nivel de desarrollo', 'Niveles de desarrollo', 'voyager-list', 'App\\DevelopmentLevel', NULL, NULL, NULL, 1, 1, '{\"order_column\":\"id\",\"order_display_column\":\"name\",\"order_direction\":\"asc\",\"default_search_key\":\"name\",\"scope\":null}', '2023-03-25 10:40:02', '2023-04-01 23:24:45'),
(25, 'technologies', 'technologies', 'Tecnología', 'Tecnologías', 'voyager-list', 'App\\Technology', NULL, NULL, NULL, 1, 1, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2023-03-29 11:37:12', '2023-04-01 23:25:22'),
(26, 'Category_faqs', 'category-faqs', 'Categoría FAQ', 'Categorías FAQ\'s', 'voyager-list', 'App\\CategoryFaq', NULL, NULL, NULL, 1, 0, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null}', '2023-04-02 17:52:53', '2023-04-02 17:52:53'),
(29, 'categoryfaqs', 'categoryfaqs', 'Categoría FAQ', 'Categorías FAQ\'s', 'voyager-list', 'App\\Categoryfaq', NULL, NULL, NULL, 1, 0, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2023-04-02 18:07:37', '2023-04-03 20:06:58'),
(31, 'categorytutorials', 'categorytutorials', 'Categoría del tutorial', 'Categorías de los tutoriales', 'voyager-puzzle', 'App\\Categorytutorial', NULL, NULL, NULL, 1, 0, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2023-04-03 19:17:29', '2023-04-03 20:07:24'),
(32, 'tutorials', 'tutorials', 'Tutorial', 'Tutoriales', 'voyager-video', 'App\\Tutorial', NULL, NULL, NULL, 1, 0, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2023-04-03 19:25:39', '2023-04-03 20:19:04'),
(33, 'categorysupports', 'categorysupports', 'Categoría de soporte', 'Categorías de soporte', 'voyager-bread', 'App\\Categorysupport', NULL, NULL, NULL, 1, 0, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2023-04-03 19:39:42', '2023-04-03 20:07:12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `development_levels`
--

CREATE TABLE `development_levels` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `development_levels`
--

INSERT INTO `development_levels` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Prototipo', NULL, NULL, NULL),
(2, 'Pilotaje', NULL, NULL, NULL),
(3, 'MVP', NULL, NULL, NULL),
(4, 'Producto estandarizado', NULL, NULL, NULL),
(5, 'Producto con certificación internacional', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `economic_sectors`
--

CREATE TABLE `economic_sectors` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `economic_sectors`
--

INSERT INTO `economic_sectors` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Agropecuario', '2023-03-22 16:23:27', '2023-03-22 16:23:27', NULL),
(2, 'Bioeconomía', '2023-03-22 16:23:27', '2023-03-22 16:23:27', NULL),
(3, 'Economía del Cuidado', '2023-03-22 16:23:27', '2023-03-22 16:23:27', NULL),
(4, 'Educación', '2023-03-22 16:23:27', '2023-03-22 16:23:27', NULL),
(5, 'Energía', '2023-03-22 16:23:27', '2023-03-22 16:23:27', NULL),
(6, 'Financiero', '2023-03-22 16:23:27', '2023-03-22 16:23:27', NULL),
(7, 'Movilidad', '2023-03-22 16:23:27', '2023-03-22 16:23:27', NULL),
(8, 'Salud', '2023-03-22 16:23:27', '2023-03-22 16:23:27', NULL),
(9, 'Silver Economía', '2023-03-22 16:23:27', '2023-03-22 16:23:27', NULL),
(10, 'Tecnología', '2023-03-22 16:23:27', '2023-03-22 16:23:27', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `email_templates`
--

CREATE TABLE `email_templates` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `faqs`
--

CREATE TABLE `faqs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_question` text COLLATE utf8mb4_unicode_ci,
  `attached_question` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_faq_id` int(11) NOT NULL,
  `state` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `question_user_id` bigint(20) NOT NULL,
  `date_question` datetime NOT NULL,
  `description_response` text COLLATE utf8mb4_unicode_ci,
  `attached_response` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `response_user_id` bigint(20) DEFAULT NULL,
  `date_response` datetime DEFAULT NULL,
  `update_user_id` bigint(20) DEFAULT NULL,
  `date_update` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `faqs`
--

INSERT INTO `faqs` (`id`, `title`, `slug`, `description_question`, `attached_question`, `category_faq_id`, `state`, `question_user_id`, `date_question`, `description_response`, `attached_response`, `response_user_id`, `date_response`, `update_user_id`, `date_update`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '¿Cómo me puedo registrar?', 'como-me-puedo-registrar', '<p><em><strong>Como puedo acceder a los servicios de Primer Cloud</strong></em></p>\n', 'public/faqs/NKJipeqOjvIlxJl6UBi61upWZENzmV4pJVfcOEJT.png', 1, 'respuesta', 1, '2023-05-16 16:35:54', 'Para poder registrarse como empresa a Primer Cloud debe seguir los siguientes pasos:\r\n<ol>\r\n<li>Para registrarse ingrese a la URL https://primer.parquesoft.co/</li>\r\n<li>De clic en el bot&oacute;n Registrarme</li>\r\n<li>Ingrese todos los datos del formulario</li>\r\n<li>Ingrese al sistema con su correo electr&oacute;nico y el NIT como contrase&ntilde;a</li>\r\n<li>Inicialmente tendra privilegios de invitado, posteriormente se analizar&aacute; su ingreso para darle privilegios de empresa.</li>\r\n</ol>', 'public/faqs/9RMtmiM4pmafSOsxJZ9cN8cqp0DWv3MhuCuqFnqU.png', 1, '2023-04-03 10:32:00', NULL, NULL, '2023-04-03 10:32:12', '2023-05-16 16:35:54', NULL),
(3, '¿Qué funcionalidades tiene Primer Cloud?', 'que-funcionalidades-tiene-primer-cloud', '<p><u>&iquest;Qu&eacute; funcionalidades tiene Primer Cloud?</u></p>\n', 'public/faqs/uEHEMQgYKTY5RC8KPiNY1iktSX7uVACMHCEJQKeP.png', 2, 'pregunta', 1, '2023-05-16 16:30:12', NULL, NULL, NULL, NULL, NULL, NULL, '2023-05-16 16:30:12', '2023-05-16 16:30:12', NULL),
(7, '¿Cómo es el envío de correos masivos?', 'como-es-el-envio-de-correos-masivos', '<p><strong>&iquest;C&oacute;mo es el env&iacute;o de correos masivos?</strong></p>\n', NULL, 2, 'pregunta', 14, '2023-05-17 14:47:42', NULL, NULL, NULL, NULL, NULL, NULL, '2023-05-17 14:47:42', '2023-05-17 14:47:42', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `impacts`
--

CREATE TABLE `impacts` (
  `id` int(10) UNSIGNED NOT NULL,
  `metrics` text COLLATE utf8mb4_unicode_ci,
  `data_collection` text COLLATE utf8mb4_unicode_ci,
  `evidence` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `project_id` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `impacts_attachments`
--

CREATE TABLE `impacts_attachments` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci,
  `url` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `impact_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `indicators`
--

CREATE TABLE `indicators` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `metodology_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `individual_emails`
--

CREATE TABLE `individual_emails` (
  `id` int(10) UNSIGNED NOT NULL,
  `from` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `to` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cc` json DEFAULT NULL,
  `cco` json DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci,
  `send_date` datetime DEFAULT NULL,
  `opening_date` datetime DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `contact_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `information_forms`
--

CREATE TABLE `information_forms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `token` text COLLATE utf8mb4_unicode_ci,
  `step_id` bigint(20) UNSIGNED DEFAULT NULL,
  `stage_id` int(11) DEFAULT NULL,
  `points` int(11) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `reminder_message` text COLLATE utf8mb4_unicode_ci,
  `reminder_message_date` date DEFAULT NULL,
  `reminder_message_mean` text COLLATE utf8mb4_unicode_ci,
  `congratulation_message` text COLLATE utf8mb4_unicode_ci,
  `congratulation_message_date` date DEFAULT NULL,
  `congratulation_message_mean` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `information_forms`
--

INSERT INTO `information_forms` (`id`, `name`, `description`, `token`, `step_id`, `stage_id`, `points`, `created_at`, `updated_at`, `reminder_message`, `reminder_message_date`, `reminder_message_mean`, `congratulation_message`, `congratulation_message_date`, `congratulation_message_mean`) VALUES
(1, 'Formulario de inscripcion, etapa Etapa Emprendimiento, proceso Vuelo por la aceleracion', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit egestas fermentum, rhoncus integer morbi. Ultrices lacinia blandit himenaeos etiam accumsan phasellus mattis fermentum sociis pellentesque suscipit litora ullamcorper, quisque velit integer cursus sapien morbi eget sed cras id torquent rhoncus. Tristique interdum ut fames id hendrerit, aenean pharetra dictum potenti donec, cursus nam consequat tellus.\n\nPellentesque tristique conubia facilisi pharetra suspendisse mus, condimentum bibendum vivamus dui litora ut congue, tortor felis montes luctus pulvinar. Leo molestie ultrices pretium mattis nisi fames aenean felis bibendum aliquam tempus, mollis class aptent cubilia parturient quisque maecenas ridiculus pharetra sem. Iaculis ultrices vivamus pharetra arcu blandit integer vel odio, eu et penatibus a nam curae tristique metus parturient, ad accumsan ultricies dui massa quam quis.', 'formulario-de-inscripcion-etapa-etapa-emprendimiento-proceso-vuelo-por-la-aceleracion', NULL, 6, 0, '2024-04-17 21:13:06', '2024-05-02 15:21:35', NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'Formulario de inscripcion, etapa Innovación, proceso Vuelo por la aceleracion', 'Formulario de inscripcion, etapa Innovación, proceso Vuelo por la aceleracion', 'formulario-de-inscripcion-etapa-innovaci-on-proceso-vuelo-por-la-aceleracion', NULL, 7, 0, '2024-04-26 05:45:35', '2024-04-26 05:45:35', NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'Formulario de inscripcion, etapa Digitalización, proceso Vuelo por la aceleracion', 'Formulario de inscripcion, etapa Digitalización, proceso Vuelo por la aceleracion', 'formulario-de-inscripcion-etapa-digitalizaci-on-proceso-vuelo-por-la-aceleracion', NULL, 8, 0, '2024-04-26 05:46:18', '2024-04-26 05:46:18', NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'Recolección de información', 'Lorem ipsum dolor sit amet consectetur adipiscing elit lacus, augue mi porttitor pharetra velit feugiat ante, placerat montes accumsan massa integer malesuada habitasse. Massa rutrum enim est placerat consequat per nulla luctus cras, faucibus egestas montes proin pellentesque sodales semper inceptos hac, eleifend tortor purus dictum torquent suscipit quis hendrerit. Tempor condimentum platea orci dui scelerisque justo nunc volutpat elementum, egestas purus nisl sed nostra cubilia sociosqu imperdiet, parturient metus pulvinar vestibulum iaculis facilisis inceptos laoreet.\n\nPenatibus consequat nascetur in aenean eleifend faucibus taciti pharetra cursus donec, porttitor neque sollicitudin urna vehicula parturient euismod lacus platea class, mi iaculis tristique imperdiet volutpat nostra congue ante conubia. Sed elementum est vulputate curabitur lobortis nulla egestas, aliquet euismod consequat fringilla sapien tincidunt parturient, habitant himenaeos vestibulum curae praesent dapibus. Lectus tempus id erat porttitor sapien dis, aliquam per et quisque vestibulum aenean neque, ornare suspendisse in nostra faucibus.', NULL, 1, NULL, 10, '2024-05-02 16:21:11', '2024-05-02 16:21:11', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `information_forms_answers`
--

CREATE TABLE `information_forms_answers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `contact_id` bigint(20) UNSIGNED NOT NULL,
  `information_form_id` bigint(20) UNSIGNED NOT NULL,
  `question_id` bigint(20) UNSIGNED NOT NULL,
  `answer` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `information_forms_answers`
--

INSERT INTO `information_forms_answers` (`id`, `contact_id`, `information_form_id`, `question_id`, `answer`, `created_at`, `updated_at`) VALUES
(9, 2, 4, 4, 'Primero', '2024-05-07 22:55:08', '2024-05-07 22:55:08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `information_form_options`
--

CREATE TABLE `information_form_options` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` int(11) NOT NULL,
  `information_form_question_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `information_form_options`
--

INSERT INTO `information_form_options` (`id`, `text`, `value`, `position`, `information_form_question_id`, `created_at`, `updated_at`) VALUES
(1, 'Tecnología', 'tecnología', 1, 2, '2024-04-26 06:09:52', '2024-04-26 06:09:52'),
(2, 'Alimentación', 'alimentación', 2, 2, '2024-04-26 06:10:09', '2024-04-26 06:10:09'),
(3, 'Moda', 'moda', 3, 2, '2024-04-26 06:10:19', '2024-04-26 06:10:19');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `information_form_questions`
--

CREATE TABLE `information_form_questions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` int(11) NOT NULL,
  `information_form_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `information_form_questions`
--

INSERT INTO `information_form_questions` (`id`, `text`, `type`, `position`, `information_form_id`, `created_at`, `updated_at`) VALUES
(1, 'Nombre del emprendimiento/empresa.', 'AC', 1, 1, '2024-04-17 21:22:43', '2024-04-26 06:08:50'),
(2, 'Sector de actividad', 'OS', 2, 1, '2024-04-19 21:17:32', '2024-04-26 06:09:09'),
(3, 'Descripción breve del producto o servicio ofrecido.', 'AL', 3, 1, '2024-04-19 21:17:39', '2024-04-26 06:10:35'),
(4, 'Modelo de negocio', 'AC', 1, 4, '2024-05-02 16:21:47', '2024-05-02 16:21:47');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `innovations`
--

CREATE TABLE `innovations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `technical_features` json DEFAULT NULL,
  `commercial_features` json DEFAULT NULL,
  `technology` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `benchmarking` text COLLATE utf8mb4_unicode_ci,
  `project_id` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lessons`
--

CREATE TABLE `lessons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `video` text COLLATE utf8mb4_unicode_ci,
  `file` text COLLATE utf8mb4_unicode_ci,
  `topic_id` bigint(20) UNSIGNED NOT NULL,
  `order` int(11) NOT NULL DEFAULT '0',
  `duration` int(11) DEFAULT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `lessons`
--

INSERT INTO `lessons` (`id`, `title`, `description`, `video`, `file`, `topic_id`, `order`, `duration`, `published`, `created_at`, `updated_at`) VALUES
(1, 'Introduccion', 'Lorem ipsum dolor sit amet consectetur adipiscing elit magna imperdiet, habitasse quam leo donec posuere suspendisse parturient integer augue faucibus, curae tincidunt habitant nostra class blandit egestas dis.', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/5iebthD1zp4?si=47rxZmYBmRcyF6q5\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>', NULL, 2, 1, 1, 1, '2024-05-06 20:06:55', '2024-05-06 22:37:36'),
(2, 'Antecedentes', 'Lorem ipsum dolor sit amet consectetur adipiscing elit magna imperdiet, habitasse quam leo donec posuere suspendisse parturient integer augue faucibus, cura', '', '/storage/files/API Settings _ Reoon Email Verifier.pdf', 2, 2, 60, 1, '2024-05-06 20:36:51', '2024-05-06 22:32:28'),
(3, 'Conocimiento Generak', 'Lorem ipsum dolor sit amet consectetur adipiscing elit magna imperdiet, habitasse quam leo donec posuere suspendisse parturient integer augue faucibus, cura', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/5iebthD1zp4?si=47rxZmYBmRcyF6q5\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>', NULL, 3, 3, 60, 1, '2024-05-06 20:48:09', '2024-05-06 20:48:09'),
(4, 'Archivo', 'Lorem ipsum dolor sit amet consectetur adipiscing elit, ullamcorper metus pretium dictumst sed at, ultricies tincidunt quam natoque sociis proin. Fames egestas pulvinar risus gravida pharetra lobortis inceptos pretium cursus sollicitudin, accumsan tellus mi mollis penatibus dui enim nunc luctus, suscipit hendrerit quam cum dignissim natoque libero bibendum nostra. Platea nullam dapibus inceptos in nibh hendrerit tristique sagittis curabitur, cras aliquam suscipit orci hac mattis bibendum ac, lacus blandit eu dis pulvinar sociis class taciti.\n\nFacilisis curabitur nascetur eu nisi cras parturient scelerisque, curae elementum ut hac non dapibus pulvinar rhoncus, morbi sollicitudin hendrerit et auctor lobortis. Odio cursus himenaeos ligula facilisi sodales nam mollis auctor, non cubilia rhoncus tortor enim malesuada dictumst, elementum aptent lacinia eget feugiat cras inceptos. Sollicitudin porttitor lacus pulvinar justo iaculis sagittis quam magna eros convallis fusce eu, condimentum sed placerat risus ridiculus bibendum mattis orci tortor facilisi ornare diam, inceptos urna magnis curae dictum ut felis semper euismod sociis morbi.', NULL, '/storage/files/Sesion-1-6.jpg', 2, 4, 10, 1, '2024-05-06 22:11:50', '2024-05-06 22:18:38');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `meetings`
--

CREATE TABLE `meetings` (
  `id` int(10) UNSIGNED NOT NULL,
  `contact_id` int(11) DEFAULT NULL,
  `meeting_date_start` date DEFAULT NULL,
  `meeting_time_start` time DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `title` text COLLATE utf8mb4_unicode_ci,
  `url` text COLLATE utf8mb4_unicode_ci,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `memberships`
--

CREATE TABLE `memberships` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `memberships`
--

INSERT INTO `memberships` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`, `description`) VALUES
(1, 'PRO', '2023-03-04 13:14:09', '2023-03-04 13:14:09', NULL, '<ul>\r\n<li>Acceso al algoritmo de identificaci&oacute;n de potenciales fondos de impacto.</li>\r\n<li>Acceso al ecosistema de impacto para ampliar tus conocimientos acerca de la inversi&oacute;n de impacto.</li>\r\n</ul>'),
(2, 'Limitless (1 Sesión)', '2023-03-06 08:34:38', '2023-03-06 08:34:38', NULL, '<section class=\"elementor-section elementor-inner-section elementor-element elementor-element-fdf4e70 elementor-hidden-tablet elementor-hidden-mobile elementor-section-boxed elementor-section-height-default elementor-section-height-default\" data-id=\"fdf4e70\" data-element_type=\"section\">\r\n<div class=\"elementor-container elementor-column-gap-default\">\r\n<div class=\"elementor-column elementor-col-16 elementor-inner-column elementor-element elementor-element-0ce2a48\" data-id=\"0ce2a48\" data-element_type=\"column\">\r\n<div class=\"elementor-widget-wrap elementor-element-populated\">\r\n<div class=\"elementor-element elementor-element-288c5ca elementor-widget elementor-widget-text-editor\" data-id=\"288c5ca\" data-element_type=\"widget\" data-widget_type=\"text-editor.default\">\r\n<div class=\"elementor-widget-container\">\r\n<ul>\r\n<li>Acceso al algoritmo de identificaci&oacute;n de potenciales fondos de impacto.</li>\r\n</ul>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n<div class=\"elementor-column elementor-col-16 elementor-inner-column elementor-element elementor-element-7b2c3c5\" data-id=\"7b2c3c5\" data-element_type=\"column\">&nbsp;</div>\r\n</div>\r\n</section>\r\n<section class=\"elementor-section elementor-inner-section elementor-element elementor-element-36b5379 elementor-hidden-tablet elementor-hidden-mobile elementor-section-boxed elementor-section-height-default elementor-section-height-default\" data-id=\"36b5379\" data-element_type=\"section\">\r\n<div class=\"elementor-container elementor-column-gap-default\">\r\n<div class=\"elementor-column elementor-col-16 elementor-inner-column elementor-element elementor-element-3e0b198\" data-id=\"3e0b198\" data-element_type=\"column\">\r\n<div class=\"elementor-widget-wrap elementor-element-populated\">\r\n<div class=\"elementor-element elementor-element-558c63a elementor-widget elementor-widget-text-editor\" data-id=\"558c63a\" data-element_type=\"widget\" data-widget_type=\"text-editor.default\">\r\n<div class=\"elementor-widget-container\">\r\n<ul>\r\n<li>Acceso al ecosistema de impacto para ampliar tus conocimientos acerca de la inversi&oacute;n de impacto.</li>\r\n</ul>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n<div class=\"elementor-column elementor-col-16 elementor-inner-column elementor-element elementor-element-406fa31\" data-id=\"406fa31\" data-element_type=\"column\">&nbsp;</div>\r\n</div>\r\n</section>\r\n<section class=\"elementor-section elementor-inner-section elementor-element elementor-element-d49c833 elementor-hidden-tablet elementor-hidden-mobile elementor-section-boxed elementor-section-height-default elementor-section-height-default\" data-id=\"d49c833\" data-element_type=\"section\">\r\n<div class=\"elementor-container elementor-column-gap-default\">\r\n<div class=\"elementor-column elementor-col-16 elementor-inner-column elementor-element elementor-element-c62d564\" data-id=\"c62d564\" data-element_type=\"column\">\r\n<div class=\"elementor-widget-wrap elementor-element-populated\">\r\n<div class=\"elementor-element elementor-element-791b4df elementor-widget elementor-widget-text-editor\" data-id=\"791b4df\" data-element_type=\"widget\" data-widget_type=\"text-editor.default\">\r\n<div class=\"elementor-widget-container\">\r\n<ul>\r\n<li>Toolkit para dise&ntilde;o de proyectos.</li>\r\n</ul>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</section>\r\n<section class=\"elementor-section elementor-inner-section elementor-element elementor-element-68abb95 elementor-hidden-tablet elementor-hidden-mobile elementor-section-boxed elementor-section-height-default elementor-section-height-default\" data-id=\"68abb95\" data-element_type=\"section\">\r\n<div class=\"elementor-container elementor-column-gap-default\">\r\n<div class=\"elementor-column elementor-col-16 elementor-inner-column elementor-element elementor-element-f73acf8\" data-id=\"f73acf8\" data-element_type=\"column\">\r\n<div class=\"elementor-widget-wrap elementor-element-populated\">\r\n<div class=\"elementor-element elementor-element-67a609a elementor-widget elementor-widget-text-editor\" data-id=\"67a609a\" data-element_type=\"widget\" data-widget_type=\"text-editor.default\">\r\n<div class=\"elementor-widget-container\">\r\n<ul>\r\n<li>Sesiones para dise&ntilde;ar un proyecto financiable:\r\n<ul>\r\n<li>Teor&iacute;a del cambio</li>\r\n<li>Modelo financiero y presupuesto de idea a impacto</li>\r\n<li>Storytelling para proyectos de impacto</li>\r\n</ul>\r\n</li>\r\n</ul>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n<div class=\"elementor-column elementor-col-16 elementor-inner-column elementor-element elementor-element-be63221\" data-id=\"be63221\" data-element_type=\"column\">&nbsp;</div>\r\n</div>\r\n</section>\r\n<section class=\"elementor-section elementor-inner-section elementor-element elementor-element-dc61e3c elementor-hidden-tablet elementor-hidden-mobile elementor-section-boxed elementor-section-height-default elementor-section-height-default\" data-id=\"dc61e3c\" data-element_type=\"section\">\r\n<div class=\"elementor-container elementor-column-gap-default\">\r\n<div class=\"elementor-column elementor-col-16 elementor-inner-column elementor-element elementor-element-5d5d9f8\" data-id=\"5d5d9f8\" data-element_type=\"column\">\r\n<div class=\"elementor-widget-wrap elementor-element-populated\">\r\n<div class=\"elementor-element elementor-element-2790633 elementor-widget elementor-widget-text-editor\" data-id=\"2790633\" data-element_type=\"widget\" data-widget_type=\"text-editor.default\">\r\n<div class=\"elementor-widget-container\">\r\n<ul>\r\n<li>Trimestres de contenido exclusivo</li>\r\n</ul>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</section>'),
(3, 'Limitless (2 Sesiones)', '2023-03-06 08:35:02', '2023-03-06 08:35:02', NULL, '<section class=\"elementor-section elementor-inner-section elementor-element elementor-element-fdf4e70 elementor-hidden-tablet elementor-hidden-mobile elementor-section-boxed elementor-section-height-default elementor-section-height-default\" data-id=\"fdf4e70\" data-element_type=\"section\">\r\n<div class=\"elementor-container elementor-column-gap-default\">\r\n<div class=\"elementor-column elementor-col-16 elementor-inner-column elementor-element elementor-element-0ce2a48\" data-id=\"0ce2a48\" data-element_type=\"column\">\r\n<div class=\"elementor-widget-wrap elementor-element-populated\">\r\n<div class=\"elementor-element elementor-element-288c5ca elementor-widget elementor-widget-text-editor\" data-id=\"288c5ca\" data-element_type=\"widget\" data-widget_type=\"text-editor.default\">\r\n<div class=\"elementor-widget-container\">\r\n<ul>\r\n<li>Acceso al algoritmo de identificaci&oacute;n de potenciales fondos de impacto.</li>\r\n</ul>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n<div class=\"elementor-column elementor-col-16 elementor-inner-column elementor-element elementor-element-7b2c3c5\" data-id=\"7b2c3c5\" data-element_type=\"column\">&nbsp;</div>\r\n</div>\r\n</section>\r\n<section class=\"elementor-section elementor-inner-section elementor-element elementor-element-36b5379 elementor-hidden-tablet elementor-hidden-mobile elementor-section-boxed elementor-section-height-default elementor-section-height-default\" data-id=\"36b5379\" data-element_type=\"section\">\r\n<div class=\"elementor-container elementor-column-gap-default\">\r\n<div class=\"elementor-column elementor-col-16 elementor-inner-column elementor-element elementor-element-3e0b198\" data-id=\"3e0b198\" data-element_type=\"column\">\r\n<div class=\"elementor-widget-wrap elementor-element-populated\">\r\n<div class=\"elementor-element elementor-element-558c63a elementor-widget elementor-widget-text-editor\" data-id=\"558c63a\" data-element_type=\"widget\" data-widget_type=\"text-editor.default\">\r\n<div class=\"elementor-widget-container\">\r\n<ul>\r\n<li>Acceso al ecosistema de impacto para ampliar tus conocimientos acerca de la inversi&oacute;n de impacto.</li>\r\n</ul>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n<div class=\"elementor-column elementor-col-16 elementor-inner-column elementor-element elementor-element-406fa31\" data-id=\"406fa31\" data-element_type=\"column\">&nbsp;</div>\r\n</div>\r\n</section>\r\n<section class=\"elementor-section elementor-inner-section elementor-element elementor-element-d49c833 elementor-hidden-tablet elementor-hidden-mobile elementor-section-boxed elementor-section-height-default elementor-section-height-default\" data-id=\"d49c833\" data-element_type=\"section\">\r\n<div class=\"elementor-container elementor-column-gap-default\">\r\n<div class=\"elementor-column elementor-col-16 elementor-inner-column elementor-element elementor-element-c62d564\" data-id=\"c62d564\" data-element_type=\"column\">\r\n<div class=\"elementor-widget-wrap elementor-element-populated\">\r\n<div class=\"elementor-element elementor-element-791b4df elementor-widget elementor-widget-text-editor\" data-id=\"791b4df\" data-element_type=\"widget\" data-widget_type=\"text-editor.default\">\r\n<div class=\"elementor-widget-container\">\r\n<ul>\r\n<li>Toolkit para dise&ntilde;o de proyectos.</li>\r\n</ul>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</section>\r\n<section class=\"elementor-section elementor-inner-section elementor-element elementor-element-68abb95 elementor-hidden-tablet elementor-hidden-mobile elementor-section-boxed elementor-section-height-default elementor-section-height-default\" data-id=\"68abb95\" data-element_type=\"section\">\r\n<div class=\"elementor-container elementor-column-gap-default\">\r\n<div class=\"elementor-column elementor-col-16 elementor-inner-column elementor-element elementor-element-f73acf8\" data-id=\"f73acf8\" data-element_type=\"column\">\r\n<div class=\"elementor-widget-wrap elementor-element-populated\">\r\n<div class=\"elementor-element elementor-element-67a609a elementor-widget elementor-widget-text-editor\" data-id=\"67a609a\" data-element_type=\"widget\" data-widget_type=\"text-editor.default\">\r\n<div class=\"elementor-widget-container\">\r\n<ul>\r\n<li>Sesiones para dise&ntilde;ar un proyecto financiable:\r\n<ul>\r\n<li>Teor&iacute;a del cambio</li>\r\n<li>Modelo financiero y presupuesto de idea a impacto</li>\r\n<li>Storytelling para proyectos de impacto</li>\r\n</ul>\r\n</li>\r\n</ul>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n<div class=\"elementor-column elementor-col-16 elementor-inner-column elementor-element elementor-element-be63221\" data-id=\"be63221\" data-element_type=\"column\">&nbsp;</div>\r\n</div>\r\n</section>\r\n<section class=\"elementor-section elementor-inner-section elementor-element elementor-element-dc61e3c elementor-hidden-tablet elementor-hidden-mobile elementor-section-boxed elementor-section-height-default elementor-section-height-default\" data-id=\"dc61e3c\" data-element_type=\"section\">\r\n<div class=\"elementor-container elementor-column-gap-default\">\r\n<div class=\"elementor-column elementor-col-16 elementor-inner-column elementor-element elementor-element-5d5d9f8\" data-id=\"5d5d9f8\" data-element_type=\"column\">\r\n<div class=\"elementor-widget-wrap elementor-element-populated\">\r\n<div class=\"elementor-element elementor-element-2790633 elementor-widget elementor-widget-text-editor\" data-id=\"2790633\" data-element_type=\"widget\" data-widget_type=\"text-editor.default\">\r\n<div class=\"elementor-widget-container\">\r\n<ul>\r\n<li>Trimestres de contenido exclusivo</li>\r\n</ul>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</section>'),
(4, 'Ilimitado de por vida', '2023-03-06 14:34:49', '2023-03-06 14:34:49', NULL, '<p>Acceso de por vida al uso de la plataforma</p>\r\n<ul>\r\n<li>Descripci&oacute;n uno del servicio</li>\r\n<li>Opci&oacute;n final</li>\r\n</ul>');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mentors`
--

CREATE TABLE `mentors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `session_duration` int(11) DEFAULT NULL,
  `step_id` bigint(20) UNSIGNED NOT NULL,
  `points` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `reminder_message` text COLLATE utf8mb4_unicode_ci,
  `reminder_message_date` date DEFAULT NULL,
  `reminder_message_mean` text COLLATE utf8mb4_unicode_ci,
  `congratulation_message` text COLLATE utf8mb4_unicode_ci,
  `congratulation_message_date` date DEFAULT NULL,
  `congratulation_message_mean` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `mentors`
--

INSERT INTO `mentors` (`id`, `name`, `email`, `phone`, `session_duration`, `step_id`, `points`, `created_at`, `updated_at`, `reminder_message`, `reminder_message_date`, `reminder_message_mean`, `congratulation_message`, `congratulation_message_date`, `congratulation_message_mean`) VALUES
(1, 'Daniel', 'danielcriollo9706@gmail.com', '3155163134', 30, 4, 10, '2024-05-06 06:31:40', '2024-05-06 07:43:12', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mentor_availabilities`
--

CREATE TABLE `mentor_availabilities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mentor_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `mentor_availabilities`
--

INSERT INTO `mentor_availabilities` (`id`, `mentor_id`, `date`, `start_time`, `end_time`, `created_at`, `updated_at`) VALUES
(7, 1, '2024-05-07', '08:00:00', '17:00:00', '2024-05-06 11:59:33', '2024-05-06 12:02:03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menus`
--

CREATE TABLE `menus` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `menus`
--

INSERT INTO `menus` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'admin', '2022-12-29 08:33:07', '2022-12-29 08:33:07');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu_items`
--

CREATE TABLE `menu_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `menu_id` int(10) UNSIGNED DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `target` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '_self',
  `icon_class` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `order` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `route` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parameters` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `menu_items`
--

INSERT INTO `menu_items` (`id`, `menu_id`, `title`, `url`, `target`, `icon_class`, `color`, `parent_id`, `order`, `created_at`, `updated_at`, `route`, `parameters`) VALUES
(1, 1, 'Escritorio', '', '_self', 'voyager-browser', '#000000', NULL, 1, '2022-12-29 08:33:07', '2022-12-29 08:53:40', 'voyager.dashboard', 'null'),
(2, 1, 'Almacenamiento', '', '_self', 'voyager-images', '#000000', 5, 3, '2022-12-29 08:33:07', '2022-12-29 08:54:12', 'voyager.media.index', 'null'),
(3, 1, 'Usuarios', '', '_self', 'voyager-person', '#000000', 11, 1, '2022-12-29 08:33:07', '2022-12-29 08:52:37', 'voyager.users.index', 'null'),
(4, 1, 'Roles', '', '_self', 'voyager-lock', NULL, 11, 2, '2022-12-29 08:33:07', '2023-02-13 15:06:42', 'voyager.roles.index', NULL),
(5, 1, 'Configuración', '', '_self', 'voyager-tools', '#000000', NULL, 20, '2022-12-29 08:33:07', '2024-05-06 04:56:01', NULL, ''),
(6, 1, 'Menú', '', '_self', 'voyager-list', '#000000', 5, 4, '2022-12-29 08:33:07', '2022-12-29 08:55:07', 'voyager.menus.index', 'null'),
(7, 1, 'Base de datos', '', '_self', 'voyager-data', '#000000', 5, 1, '2022-12-29 08:33:07', '2022-12-29 08:54:02', 'voyager.database.index', 'null'),
(8, 1, 'Compass', '', '_self', 'voyager-compass', NULL, 5, 5, '2022-12-29 08:33:07', '2023-03-29 11:37:34', 'voyager.compass.index', NULL),
(9, 1, 'BREAD', '', '_self', 'voyager-bread', NULL, 5, 2, '2022-12-29 08:33:07', '2022-12-29 08:53:52', 'voyager.bread.index', NULL),
(10, 1, 'Ajustes', '', '_self', 'voyager-settings', '#000000', 5, 6, '2022-12-29 08:33:07', '2023-03-29 11:37:34', 'voyager.settings.index', 'null'),
(11, 1, 'Gest. Usuarios', '', '_self', 'fa fa-users', '#000000', NULL, 5, '2022-12-29 08:52:18', '2023-03-29 16:48:23', NULL, ''),
(12, 1, 'Plan. Terreno Comercial', '/admin/commercial-lands', '_self', 'fa fa-building-o', '#000000', NULL, 6, '2023-01-02 16:12:47', '2023-03-29 16:48:23', NULL, ''),
(13, 1, 'Convocatorias', '/admin/announcements', '_self', 'fa fa-bullhorn', '#000000', 30, 4, '2023-01-04 20:38:41', '2023-03-23 09:53:10', NULL, ''),
(14, 1, 'Formularios Widgets', '/admin/forms', '_self', 'voyager-news', '#000000', 30, 3, '2023-01-12 20:54:35', '2023-03-23 09:53:10', NULL, ''),
(15, 1, 'Contactos', '/admin/contacts', '_self', 'fa fa-address-card', '#000000', 30, 2, '2023-01-14 15:45:03', '2023-03-23 09:53:10', NULL, ''),
(16, 1, 'Permisos', '', '_self', 'voyager-key', NULL, 11, 3, '2023-01-24 16:26:18', '2023-02-13 15:06:42', 'voyager.permissions.index', NULL),
(17, 1, 'Planificación de Contacto', '/admin/contact-schedules', '_self', 'voyager-telephone', '#000000', 30, 5, '2023-01-24 19:35:00', '2023-03-23 09:53:10', NULL, ''),
(18, 1, 'Ingeniería social', '', '_self', 'fa fa-search', '#000000', NULL, 9, '2023-01-31 14:08:24', '2023-04-10 18:13:55', NULL, ''),
(19, 1, 'Banco de preguntas', '/admin/questions-social-engineering', '_self', 'fa fa-question', '#000000', 18, 2, '2023-01-31 14:10:11', '2023-02-10 19:50:25', NULL, ''),
(20, 1, 'Proceso Ingeniería Social', '/admin/social-engineering', '_self', 'fa fa-search', '#000000', 18, 1, '2023-01-31 14:11:56', '2023-02-10 19:48:16', NULL, ''),
(22, 1, 'Mensajes de Valor', '/admin/message-management', '_self', 'fa fa-envelope', '#000000', 28, 1, '2023-02-06 14:17:08', '2023-02-09 16:21:03', NULL, ''),
(23, 1, 'Registro de Tareas', '/admin/tasks', '_self', 'fa fa-tasks', '#000000', 28, 3, '2023-02-06 16:51:26', '2023-02-09 16:49:52', NULL, ''),
(24, 1, 'Registro de Agendamientos', '/admin/meetings', '_self', 'voyager-calendar', '#000000', 28, 4, '2023-02-06 16:51:56', '2023-02-09 16:49:52', NULL, ''),
(25, 1, 'Tareas', '', '_self', 'fa fa-tasks', NULL, 52, 7, '2023-02-06 19:11:22', '2023-03-29 11:37:34', 'voyager.tasks-types.index', NULL),
(26, 1, 'Agentes', '', '_self', 'voyager-person', '#000000', 11, 4, '2023-02-06 19:38:39', '2023-02-13 15:06:42', 'voyager.agents.index', 'null'),
(27, 1, 'Plantillas Correos', '/admin/mailing-templates', '_self', 'voyager-mail', '#000000', 28, 2, '2023-02-08 22:25:13', '2023-02-09 16:49:52', NULL, ''),
(28, 1, 'Gestión Comercial', '', '_self', 'fa fa-briefcase', '#000000', NULL, 10, '2023-02-09 16:20:26', '2023-04-10 18:13:55', NULL, ''),
(29, 1, 'Mailing Individual', '/admin/mailing-individual', '_self', 'voyager-person', '#000000', 28, 5, '2023-02-09 16:50:41', '2023-02-09 16:50:51', NULL, ''),
(30, 1, 'Ges. Base de datos', '', '_self', 'voyager-data', '#000000', NULL, 7, '2023-02-10 19:59:17', '2023-03-29 16:48:23', NULL, ''),
(31, 1, 'Planificación de Tareas', '/admin/task-schedules', '_self', 'voyager-calendar', '#000000', NULL, 12, '2023-02-10 20:52:59', '2023-04-10 18:13:55', NULL, ''),
(32, 1, 'Mailing Masivo', '/admin/mailing-massive', '_self', 'voyager-mail', '#000000', 28, 7, '2023-02-15 23:04:17', '2023-04-17 15:51:17', NULL, ''),
(33, 1, 'Caracterización empresas', '/admin/characterization', '_self', 'voyager-news', '#000000', NULL, 11, '2023-03-04 10:13:50', '2023-04-10 18:13:55', NULL, ''),
(34, 1, 'Membresias', '', '_self', 'voyager-credit-cards', NULL, 52, 1, '2023-03-04 13:11:00', '2023-03-24 17:11:32', 'voyager.memberships.index', NULL),
(42, 1, 'Proyectos', '/admin/projects', '_self', 'voyager-certificate', '#000000', NULL, 8, '2023-03-14 07:10:00', '2023-04-11 11:45:48', NULL, ''),
(44, 1, 'Scalings', '', '_self', 'voyager-params', NULL, 53, 1, '2023-03-14 07:26:24', '2023-04-10 18:13:55', 'voyager.scalings.index', NULL),
(45, 1, 'Impacts', '', '_self', 'voyager-bubble-hear', NULL, 53, 2, '2023-03-14 07:30:13', '2023-04-10 18:13:55', 'voyager.impacts.index', NULL),
(46, 1, 'Tipos de empresa', '', '_self', 'voyager-list', NULL, 52, 2, '2023-03-22 11:11:08', '2023-03-24 17:11:32', 'voyager.company-types.index', NULL),
(47, 1, 'Sectores económicos', '', '_self', 'voyager-list', NULL, 52, 3, '2023-03-22 11:23:12', '2023-03-24 17:11:32', 'voyager.economic-sectors.index', NULL),
(48, 1, 'Cargos Empresas', '', '_self', 'voyager-list', NULL, 52, 4, '2023-03-22 11:28:59', '2023-03-24 17:11:32', 'voyager.company-charges.index', NULL),
(49, 1, 'Mi Empresa', '/admin/profile-company', '_self', 'voyager-company', '#000000', 57, 1, '2023-03-22 14:07:14', '2023-03-28 09:05:52', NULL, ''),
(50, 1, 'Empresas Primer Cloud', '/admin/contacts-cloud', '_self', 'voyager-company', '#000000', 30, 1, '2023-03-23 09:53:02', '2023-03-23 09:55:49', NULL, ''),
(51, 1, 'Algoritmo', '/admin/my-forms', '_self', 'fa fa-wpforms', '#000000', 57, 2, '2023-03-24 11:56:53', '2023-03-28 09:05:54', NULL, ''),
(52, 1, 'Parametrización', '', '_self', 'voyager-puzzle', '#000000', NULL, 14, '2023-03-24 17:09:55', '2023-04-10 18:13:55', NULL, ''),
(53, 1, 'BREAD Voyager (Eliminar)', '', '_self', 'voyager-bread', '#000000', NULL, 13, '2023-03-24 17:11:13', '2023-04-10 18:13:55', NULL, ''),
(54, 1, 'Productos / Servicios', '/admin/products-services', '_self', 'fa fa-briefcase', '#000000', 57, 3, '2023-03-24 17:39:43', '2023-03-28 09:05:54', NULL, ''),
(55, 1, 'Niveles de desarrollo', '', '_self', 'voyager-list', '#000000', 52, 5, '2023-03-25 10:40:02', '2023-03-25 10:40:42', 'voyager.development-levels.index', 'null'),
(56, 1, 'Modelos de Negocio', '/admin/business-models', '_self', 'fa fa-sitemap', '#000000', 57, 4, '2023-03-27 14:19:52', '2023-03-28 09:05:56', NULL, ''),
(57, 1, 'Registro Empresas', '', '_self', 'fa fa-pencil-square', '#000000', NULL, 2, '2023-03-28 09:05:42', '2023-03-28 09:05:51', NULL, ''),
(59, 1, 'Verif. de viabilidad', '/admin/viability-check', '_self', 'fa fa-check-square-o', '#000000', NULL, 3, '2023-03-28 09:09:11', '2023-03-29 11:37:26', NULL, ''),
(60, 1, 'Tecnologías', '', '_self', 'voyager-list', NULL, 52, 6, '2023-03-29 11:37:12', '2023-03-29 11:37:34', 'voyager.technologies.index', NULL),
(61, 1, 'Pathway Autogestión', '/admin/self-management', '_self', 'fa fa-cogs', '#000000', NULL, 4, '2023-03-29 16:48:09', '2023-03-29 16:48:44', NULL, ''),
(63, 1, 'Categorías FAQ\'s', '', '_self', 'voyager-list', NULL, 65, 4, '2023-04-02 18:07:37', '2023-05-15 17:22:34', 'voyager.categoryfaqs.index', NULL),
(64, 1, 'Configura mesa ayuda', '', '_self', 'voyager-boat', '#ffffff', NULL, 17, '2023-04-03 09:07:52', '2024-04-26 05:39:09', NULL, ''),
(65, 1, 'Mesa de ayuda', '', '_self', 'voyager-lifebuoy', '#fafafa', NULL, 21, '2023-04-03 09:09:23', '2024-05-06 04:56:01', NULL, ''),
(68, 1, 'Categorías tutoriales', '', '_self', 'voyager-puzzle', '#000000', 65, 5, '2023-04-03 19:17:29', '2023-05-15 17:22:34', 'voyager.categorytutorials.index', 'null'),
(70, 1, 'Categorías de soporte', '', '_self', 'voyager-bread', NULL, 65, 6, '2023-04-03 19:39:42', '2023-05-15 17:22:28', 'voyager.categorysupports.index', NULL),
(72, 1, 'Bandeja de salida individual', '/admin/single-outbox', '_self', 'fa fa-inbox', '#000000', 28, 6, '2023-04-17 15:50:55', '2023-04-17 15:51:51', NULL, ''),
(73, 1, 'Bandeja de salida masivo', '/admin/massive-outbox', '_self', 'fa fa-inbox', '#000000', 28, 8, '2023-04-18 09:01:51', '2023-04-18 09:01:59', NULL, ''),
(74, 1, 'Modelos De Propuestas', '/admin/proposal-templates', '_self', 'fa fa-folder', '#000000', NULL, 15, '2023-04-20 16:52:16', '2023-04-20 16:52:58', NULL, ''),
(75, 1, 'Propuestas', '/admin/proposals', '_self', 'fa fa-briefcase', '#000000', NULL, 16, '2023-04-21 16:14:42', '2023-04-21 16:14:51', NULL, ''),
(76, 1, 'FAQ\'s', '/admin/faqs', '_self', 'voyager-logbook', '#000000', 65, 1, '2023-05-15 17:20:32', '2023-05-15 17:20:38', NULL, ''),
(77, 1, 'Soportes', '/admin/support', '_self', 'voyager-lifebuoy', '#000000', 65, 2, '2023-05-15 17:22:12', '2023-05-15 17:31:49', NULL, ''),
(78, 1, 'Tutoriales', '/admin/videotutorials', '_self', 'fa fa-file-video-o', '#000000', 65, 3, '2023-05-17 17:52:40', '2023-05-17 17:52:45', NULL, ''),
(79, 1, 'Procesos', '/admin/processes', '_self', 'voyager-rocket', '#000000', NULL, 18, '2024-04-11 20:47:28', '2024-04-26 05:39:36', NULL, ''),
(80, 1, 'Mis procesos', '/admin/my-processes', '_self', 'voyager-rocket', '#000000', NULL, 19, '2024-05-06 04:23:52', '2024-05-06 04:56:01', NULL, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `message_templates`
--

CREATE TABLE `message_templates` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  `commercial_action_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `metodologies`
--

CREATE TABLE `metodologies` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `solution_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2016_01_01_000000_add_voyager_user_fields', 1),
(4, '2016_01_01_000000_create_data_types_table', 1),
(5, '2016_05_19_173453_create_menu_table', 1),
(6, '2016_10_21_190000_create_roles_table', 1),
(7, '2016_10_21_190000_create_settings_table', 1),
(8, '2016_11_30_135954_create_permission_table', 1),
(9, '2016_11_30_141208_create_permission_role_table', 1),
(10, '2016_12_26_201236_data_types__add__server_side', 1),
(11, '2017_01_13_000000_add_route_to_menu_items_table', 1),
(12, '2017_01_14_005015_create_translations_table', 1),
(13, '2017_01_15_000000_make_table_name_nullable_in_permissions_table', 1),
(14, '2017_03_06_000000_add_controller_to_data_types_table', 1),
(15, '2017_04_21_000000_add_order_to_data_rows_table', 1),
(16, '2017_07_05_210000_add_policyname_to_data_types_table', 1),
(17, '2017_08_05_000000_add_group_to_settings_table', 1),
(18, '2017_11_26_013050_add_user_role_relationship', 1),
(19, '2017_11_26_015000_create_user_roles_table', 1),
(20, '2018_03_11_000000_add_user_settings', 1),
(21, '2018_03_14_000000_add_details_to_data_types_table', 1),
(22, '2018_03_16_000000_make_settings_value_nullable', 1),
(23, '2019_08_19_000000_create_failed_jobs_table', 1),
(24, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(25, '2016_06_01_000001_create_oauth_auth_codes_table', 2),
(26, '2016_06_01_000002_create_oauth_access_tokens_table', 2),
(27, '2016_06_01_000003_create_oauth_refresh_tokens_table', 2),
(28, '2016_06_01_000004_create_oauth_clients_table', 2),
(29, '2016_06_01_000005_create_oauth_personal_access_clients_table', 2),
(30, '2023_01_23_083910_create_announcements_table', 0),
(31, '2023_01_23_083910_create_announcements_forms_table', 0),
(32, '2023_01_23_083910_create_announcements_forms_options_table', 0),
(33, '2023_01_23_083910_create_answers_form_4_table', 0),
(34, '2023_01_23_083910_create_answers_form_5_table', 0),
(35, '2023_01_23_083910_create_commercial_actions_table', 0),
(36, '2023_01_23_083910_create_commercial_form_actions_table', 0),
(37, '2023_01_23_083910_create_commercial_form_options_table', 0),
(38, '2023_01_23_083910_create_commercial_form_questions_table', 0),
(39, '2023_01_23_083910_create_commercial_forms_table', 0),
(40, '2023_01_23_083910_create_commercial_lands_table', 0),
(41, '2023_01_23_083910_create_commercial_strategies_table', 0),
(42, '2023_01_23_083910_create_contacts_table', 0),
(43, '2023_01_23_083910_create_data_rows_table', 0),
(44, '2023_01_23_083910_create_data_types_table', 0),
(45, '2023_01_23_083910_create_failed_jobs_table', 0),
(46, '2023_01_23_083910_create_menu_items_table', 0),
(47, '2023_01_23_083910_create_menus_table', 0),
(48, '2023_01_23_083910_create_oauth_access_tokens_table', 0),
(49, '2023_01_23_083910_create_oauth_auth_codes_table', 0),
(50, '2023_01_23_083910_create_oauth_clients_table', 0),
(51, '2023_01_23_083910_create_oauth_personal_access_clients_table', 0),
(52, '2023_01_23_083910_create_oauth_refresh_tokens_table', 0),
(53, '2023_01_23_083910_create_password_resets_table', 0),
(54, '2023_01_23_083910_create_permission_role_table', 0),
(55, '2023_01_23_083910_create_permissions_table', 0),
(56, '2023_01_23_083910_create_personal_access_tokens_table', 0),
(57, '2023_01_23_083910_create_roles_table', 0),
(58, '2023_01_23_083910_create_settings_table', 0),
(59, '2023_01_23_083910_create_translations_table', 0),
(60, '2023_01_23_083910_create_user_roles_table', 0),
(61, '2023_01_23_083911_add_foreign_keys_to_data_rows_table', 0),
(62, '2023_01_23_083911_add_foreign_keys_to_menu_items_table', 0),
(63, '2023_01_23_083911_add_foreign_keys_to_permission_role_table', 0),
(64, '2023_01_23_083911_add_foreign_keys_to_user_roles_table', 0),
(65, '2023_02_10_090326_create_jobs_table', 3),
(66, '2024_04_05_173231_create_processes_table', 4),
(69, '2024_04_08_160639_create_courses_table', 5),
(70, '2024_04_05_173715_create_stages_table', 6),
(71, '2024_04_08_155518_create_steps_table', 7),
(72, '2024_04_08_171314_create_information_forms_table', 8),
(73, '2024_04_10_152906_create_information_form_questions_table', 9),
(74, '2024_04_10_154014_create_information_form_options_table', 10),
(75, '2024_04_15_161141_create_topics_table', 11),
(76, '2024_04_15_163645_create_presential_activities_table', 12),
(77, '2024_04_16_155239_create_presential_activities_groups_table', 13),
(78, '2024_04_16_155830_create_challenges_table', 13),
(79, '2024_04_18_151645_create_information_form_answers_table', 14),
(80, '2024_04_19_153503_create_contacts_stages_table', 15),
(81, '2024_04_23_160412_create_contacts_challenges_table', 15),
(82, '2024_04_24_165831_create_contacts_information_forms_table', 16),
(83, '2024_05_06_010547_create_mentors_table', 16),
(84, '2024_05_06_010554_create_mentor_availabilities_table', 16),
(85, '2024_05_06_071910_create_contacts_mentoring_table', 17),
(86, '2024_05_06_143636_create_lessons_table', 17);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('00602df2368ba2824da3cdc14d5d23f07ca796fd582eb66334660391516c702c7a2d71f95f9a019e', 1, 1, 'MyApp', '[]', 0, '2023-01-16 16:49:03', '2023-01-16 16:49:03', '2024-01-16 11:49:03'),
('237f9ca71b0497fdc5fca71f72f12ea0bd318b8c4b8527a75e8fdba0baf7e2fe752558d934cf363a', 1, 1, 'MyApp', '[]', 0, '2023-02-02 22:30:54', '2023-02-02 22:30:54', '2024-02-02 17:30:54'),
('317ff37cf9a3c952fa6f51e8c49585ba0ab73c7288058cc3007dc9e88f42cedf0580d4c0b36ad9d6', 1, 1, 'MyApp', '[]', 0, '2023-01-26 21:20:19', '2023-01-26 21:20:19', '2024-01-26 16:20:19'),
('3bfae995862b86f31286976960291bddb9f86503194d5cbf193390d229cd021cb4db6d3beae62407', 1, 1, 'MyApp', '[]', 0, '2023-02-02 22:39:28', '2023-02-02 22:39:28', '2024-02-02 17:39:28'),
('8490da0cdb8ee589d15d321060de5ad4958daf7be015bf58ac3161b95ee93ccff16af2ceee7876bd', 1, 1, 'MyApp', '[]', 0, '2023-01-23 19:19:23', '2023-01-23 19:19:23', '2024-01-23 14:19:23'),
('e97faed9fa371ac80002e2d2ed93f6179b190495fcd19af3514ec65f7b07045cd47d13e817a24fb9', 1, 1, 'MyApp', '[]', 0, '2023-02-24 14:32:53', '2023-02-24 14:32:53', '2024-02-24 14:32:53');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `provider`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Laravel Personal Access Client', 'NAe0onznCVjaERZ5mPiTOLYE7GTPGC907OH0IJrS', NULL, 'http://localhost', 1, 0, 0, '2023-01-16 03:31:23', '2023-01-16 03:31:23'),
(2, NULL, 'Laravel Password Grant Client', 'CQwAp9YZgstHdh7p9QoJwwMiYVcxUzQ3t1p1yIX1', 'users', 'http://localhost', 0, 1, 0, '2023-01-16 03:31:23', '2023-01-16 03:31:23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2023-01-16 03:31:23', '2023-01-16 03:31:23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `table_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `permissions`
--

INSERT INTO `permissions` (`id`, `key`, `table_name`, `created_at`, `updated_at`) VALUES
(1, 'browse_admin', NULL, '2022-12-29 08:33:08', '2022-12-29 08:33:08'),
(2, 'browse_bread', NULL, '2022-12-29 08:33:08', '2022-12-29 08:33:08'),
(3, 'browse_database', NULL, '2022-12-29 08:33:08', '2022-12-29 08:33:08'),
(4, 'browse_media', NULL, '2022-12-29 08:33:08', '2022-12-29 08:33:08'),
(5, 'browse_compass', NULL, '2022-12-29 08:33:08', '2022-12-29 08:33:08'),
(6, 'browse_menus', 'menus', '2022-12-29 08:33:08', '2022-12-29 08:33:08'),
(7, 'read_menus', 'menus', '2022-12-29 08:33:08', '2022-12-29 08:33:08'),
(8, 'edit_menus', 'menus', '2022-12-29 08:33:08', '2022-12-29 08:33:08'),
(9, 'add_menus', 'menus', '2022-12-29 08:33:08', '2022-12-29 08:33:08'),
(10, 'delete_menus', 'menus', '2022-12-29 08:33:08', '2022-12-29 08:33:08'),
(11, 'browse_roles', 'roles', '2022-12-29 08:33:08', '2022-12-29 08:33:08'),
(12, 'read_roles', 'roles', '2022-12-29 08:33:08', '2022-12-29 08:33:08'),
(13, 'edit_roles', 'roles', '2022-12-29 08:33:08', '2022-12-29 08:33:08'),
(14, 'add_roles', 'roles', '2022-12-29 08:33:08', '2022-12-29 08:33:08'),
(15, 'delete_roles', 'roles', '2022-12-29 08:33:08', '2022-12-29 08:33:08'),
(16, 'browse_users', 'users', '2022-12-29 08:33:08', '2022-12-29 08:33:08'),
(17, 'read_users', 'users', '2022-12-29 08:33:08', '2022-12-29 08:33:08'),
(18, 'edit_users', 'users', '2022-12-29 08:33:08', '2022-12-29 08:33:08'),
(19, 'add_users', 'users', '2022-12-29 08:33:08', '2022-12-29 08:33:08'),
(20, 'delete_users', 'users', '2022-12-29 08:33:08', '2022-12-29 08:33:08'),
(21, 'browse_settings', 'settings', '2022-12-29 08:33:08', '2022-12-29 08:33:08'),
(22, 'read_settings', 'settings', '2022-12-29 08:33:08', '2022-12-29 08:33:08'),
(23, 'edit_settings', 'settings', '2022-12-29 08:33:08', '2022-12-29 08:33:08'),
(24, 'add_settings', 'settings', '2022-12-29 08:33:08', '2022-12-29 08:33:08'),
(25, 'delete_settings', 'settings', '2022-12-29 08:33:08', '2022-12-29 08:33:08'),
(26, 'browse_permissions', 'permissions', '2023-01-24 16:26:18', '2023-01-24 16:26:18'),
(27, 'read_permissions', 'permissions', '2023-01-24 16:26:18', '2023-01-24 16:26:18'),
(28, 'edit_permissions', 'permissions', '2023-01-24 16:26:18', '2023-01-24 16:26:18'),
(29, 'add_permissions', 'permissions', '2023-01-24 16:26:18', '2023-01-24 16:26:18'),
(30, 'delete_permissions', 'permissions', '2023-01-24 16:26:18', '2023-01-24 16:26:18'),
(31, 'browse_commercial-lands', 'Autogestión - Terrenos', '2023-01-24 16:27:00', '2023-03-24 17:34:52'),
(32, 'browse_forms', 'Formularios', '2023-01-24 16:34:09', '2023-03-24 17:35:44'),
(33, 'browse_announcements', 'announcements', '2023-01-24 19:22:58', '2023-01-24 19:22:58'),
(34, 'browse_contacts', 'contacts', '2023-01-24 19:25:03', '2023-01-24 19:25:03'),
(35, 'browse_contact-schedules', 'Agente', '2023-01-27 22:08:41', '2023-04-12 16:12:52'),
(37, 'browse_tasks_types', 'tasks_types', '2023-02-06 19:11:22', '2023-02-06 19:11:22'),
(38, 'read_tasks_types', 'tasks_types', '2023-02-06 19:11:22', '2023-02-06 19:11:22'),
(39, 'edit_tasks_types', 'tasks_types', '2023-02-06 19:11:22', '2023-02-06 19:11:22'),
(40, 'add_tasks_types', 'tasks_types', '2023-02-06 19:11:22', '2023-02-06 19:11:22'),
(41, 'delete_tasks_types', 'tasks_types', '2023-02-06 19:11:22', '2023-02-06 19:11:22'),
(42, 'browse_agents', 'agents', '2023-02-06 19:38:39', '2023-02-06 19:38:39'),
(43, 'read_agents', 'agents', '2023-02-06 19:38:39', '2023-02-06 19:38:39'),
(44, 'edit_agents', 'agents', '2023-02-06 19:38:39', '2023-02-06 19:38:39'),
(45, 'add_agents', 'agents', '2023-02-06 19:38:39', '2023-02-06 19:38:39'),
(46, 'delete_agents', 'agents', '2023-02-06 19:38:39', '2023-02-06 19:38:39'),
(47, 'browse_social-engineering', 'social-engineering', '2023-02-10 19:43:25', '2023-02-10 19:43:25'),
(48, 'browse_questions-social-engineering', 'social-engineering', '2023-02-10 19:50:50', '2023-02-10 19:50:50'),
(49, 'browse_message-management', 'commercial management', NULL, NULL),
(50, 'browse_mailing-templates', 'commercial management', NULL, NULL),
(51, 'browse_tasks', 'commercial management', NULL, NULL),
(52, 'browse_meetings', 'commercial management', NULL, NULL),
(53, 'browse_mailing-individual', 'commercial management', NULL, NULL),
(54, 'browse_characterization', 'Characterization', '2023-03-04 10:15:08', '2023-03-04 10:15:08'),
(55, 'browse_memberships', 'memberships', '2023-03-04 13:11:00', '2023-03-04 13:11:00'),
(56, 'read_memberships', 'memberships', '2023-03-04 13:11:00', '2023-03-04 13:11:00'),
(57, 'edit_memberships', 'memberships', '2023-03-04 13:11:00', '2023-03-04 13:11:00'),
(58, 'add_memberships', 'memberships', '2023-03-04 13:11:00', '2023-03-04 13:11:00'),
(59, 'delete_memberships', 'memberships', '2023-03-04 13:11:00', '2023-03-04 13:11:00'),
(70, 'browse_mailing-massive', 'commercial_management', '2023-03-06 10:39:13', '2023-03-06 10:39:13'),
(71, 'browse_task-schedules', 'Agente', '2023-03-06 10:39:29', '2023-04-12 16:11:31'),
(102, 'browse_scalings', 'scalings', '2023-03-14 07:26:24', '2023-03-14 07:26:24'),
(103, 'read_scalings', 'scalings', '2023-03-14 07:26:24', '2023-03-14 07:26:24'),
(104, 'edit_scalings', 'scalings', '2023-03-14 07:26:24', '2023-03-14 07:26:24'),
(105, 'add_scalings', 'scalings', '2023-03-14 07:26:24', '2023-03-14 07:26:24'),
(106, 'delete_scalings', 'scalings', '2023-03-14 07:26:24', '2023-03-14 07:26:24'),
(107, 'browse_impacts', 'impacts', '2023-03-14 07:30:13', '2023-03-14 07:30:13'),
(108, 'read_impacts', 'impacts', '2023-03-14 07:30:13', '2023-03-14 07:30:13'),
(109, 'edit_impacts', 'impacts', '2023-03-14 07:30:13', '2023-03-14 07:30:13'),
(110, 'add_impacts', 'impacts', '2023-03-14 07:30:13', '2023-03-14 07:30:13'),
(111, 'delete_impacts', 'impacts', '2023-03-14 07:30:13', '2023-03-14 07:30:13'),
(112, 'browse_company_types', 'company_types', '2023-03-22 11:11:08', '2023-03-22 11:11:08'),
(113, 'read_company_types', 'company_types', '2023-03-22 11:11:08', '2023-03-22 11:11:08'),
(114, 'edit_company_types', 'company_types', '2023-03-22 11:11:08', '2023-03-22 11:11:08'),
(115, 'add_company_types', 'company_types', '2023-03-22 11:11:08', '2023-03-22 11:11:08'),
(116, 'delete_company_types', 'company_types', '2023-03-22 11:11:08', '2023-03-22 11:11:08'),
(117, 'browse_economic_sectors', 'economic_sectors', '2023-03-22 11:23:12', '2023-03-22 11:23:12'),
(118, 'read_economic_sectors', 'economic_sectors', '2023-03-22 11:23:12', '2023-03-22 11:23:12'),
(119, 'edit_economic_sectors', 'economic_sectors', '2023-03-22 11:23:12', '2023-03-22 11:23:12'),
(120, 'add_economic_sectors', 'economic_sectors', '2023-03-22 11:23:12', '2023-03-22 11:23:12'),
(121, 'delete_economic_sectors', 'economic_sectors', '2023-03-22 11:23:12', '2023-03-22 11:23:12'),
(122, 'browse_company_charges', 'company_charges', '2023-03-22 11:28:59', '2023-03-22 11:28:59'),
(123, 'read_company_charges', 'company_charges', '2023-03-22 11:28:59', '2023-03-22 11:28:59'),
(124, 'edit_company_charges', 'company_charges', '2023-03-22 11:28:59', '2023-03-22 11:28:59'),
(125, 'add_company_charges', 'company_charges', '2023-03-22 11:28:59', '2023-03-22 11:28:59'),
(126, 'delete_company_charges', 'company_charges', '2023-03-22 11:28:59', '2023-03-22 11:28:59'),
(127, 'browse_profile-company', 'Empresas', '2023-03-22 14:17:50', '2023-03-24 18:03:24'),
(128, 'browse_my-forms', 'Empresas', '2023-03-24 17:13:08', '2023-03-24 18:03:14'),
(129, 'browse_contacts-cloud', 'BD - Contactos', '2023-03-24 17:30:13', '2023-03-24 17:30:13'),
(130, 'browse_products-services', 'Empresas', '2023-03-24 18:03:02', '2023-03-24 18:03:34'),
(131, 'browse_development_levels', 'development_levels', '2023-03-25 10:40:02', '2023-03-25 10:40:02'),
(132, 'read_development_levels', 'development_levels', '2023-03-25 10:40:02', '2023-03-25 10:40:02'),
(133, 'edit_development_levels', 'development_levels', '2023-03-25 10:40:02', '2023-03-25 10:40:02'),
(134, 'add_development_levels', 'development_levels', '2023-03-25 10:40:02', '2023-03-25 10:40:02'),
(135, 'delete_development_levels', 'development_levels', '2023-03-25 10:40:02', '2023-03-25 10:40:02'),
(136, 'browse_business-models', 'Empresas', '2023-03-27 14:20:33', '2023-03-27 14:20:33'),
(137, 'browse_technologies', 'technologies', '2023-03-29 11:37:12', '2023-03-29 11:37:12'),
(138, 'read_technologies', 'technologies', '2023-03-29 11:37:12', '2023-03-29 11:37:12'),
(139, 'edit_technologies', 'technologies', '2023-03-29 11:37:12', '2023-03-29 11:37:12'),
(140, 'add_technologies', 'technologies', '2023-03-29 11:37:12', '2023-03-29 11:37:12'),
(141, 'delete_technologies', 'technologies', '2023-03-29 11:37:12', '2023-03-29 11:37:12'),
(142, 'browse_self-management', 'Empresas', '2023-03-29 16:49:28', '2023-03-29 16:49:28'),
(143, 'browse_Category_faqs', 'Category_faqs', '2023-04-02 17:52:53', '2023-04-02 17:52:53'),
(144, 'read_Category_faqs', 'Category_faqs', '2023-04-02 17:52:53', '2023-04-02 17:52:53'),
(145, 'edit_Category_faqs', 'Category_faqs', '2023-04-02 17:52:53', '2023-04-02 17:52:53'),
(146, 'add_Category_faqs', 'Category_faqs', '2023-04-02 17:52:53', '2023-04-02 17:52:53'),
(147, 'delete_Category_faqs', 'Category_faqs', '2023-04-02 17:52:53', '2023-04-02 17:52:53'),
(148, 'browse_categoryfaqs', 'categoryfaqs', '2023-04-02 18:07:37', '2023-04-02 18:07:37'),
(149, 'read_categoryfaqs', 'categoryfaqs', '2023-04-02 18:07:37', '2023-04-02 18:07:37'),
(150, 'edit_categoryfaqs', 'categoryfaqs', '2023-04-02 18:07:37', '2023-04-02 18:07:37'),
(151, 'add_categoryfaqs', 'categoryfaqs', '2023-04-02 18:07:37', '2023-04-02 18:07:37'),
(152, 'delete_categoryfaqs', 'categoryfaqs', '2023-04-02 18:07:37', '2023-04-02 18:07:37'),
(158, 'browse_categorytutorials', 'categorytutorials', '2023-04-03 19:17:29', '2023-04-03 19:17:29'),
(159, 'read_categorytutorials', 'categorytutorials', '2023-04-03 19:17:29', '2023-04-03 19:17:29'),
(160, 'edit_categorytutorials', 'categorytutorials', '2023-04-03 19:17:29', '2023-04-03 19:17:29'),
(161, 'add_categorytutorials', 'categorytutorials', '2023-04-03 19:17:29', '2023-04-03 19:17:29'),
(162, 'delete_categorytutorials', 'categorytutorials', '2023-04-03 19:17:29', '2023-04-03 19:17:29'),
(163, 'browse_tutorials', 'tutorials', '2023-04-03 19:25:39', '2023-04-03 19:25:39'),
(164, 'read_tutorials', 'tutorials', '2023-04-03 19:25:39', '2023-04-03 19:25:39'),
(165, 'edit_tutorials', 'tutorials', '2023-04-03 19:25:39', '2023-04-03 19:25:39'),
(166, 'add_tutorials', 'tutorials', '2023-04-03 19:25:39', '2023-04-03 19:25:39'),
(167, 'delete_tutorials', 'tutorials', '2023-04-03 19:25:39', '2023-04-03 19:25:39'),
(168, 'browse_categorysupports', 'categorysupports', '2023-04-03 19:39:42', '2023-04-03 19:39:42'),
(169, 'read_categorysupports', 'categorysupports', '2023-04-03 19:39:42', '2023-04-03 19:39:42'),
(170, 'edit_categorysupports', 'categorysupports', '2023-04-03 19:39:42', '2023-04-03 19:39:42'),
(171, 'add_categorysupports', 'categorysupports', '2023-04-03 19:39:42', '2023-04-03 19:39:42'),
(172, 'delete_categorysupports', 'categorysupports', '2023-04-03 19:39:42', '2023-04-03 19:39:42'),
(178, 'browse_viability-check', 'Empresas', '2023-04-12 15:55:24', '2023-04-12 15:55:24'),
(179, 'browse_projects', 'Proyectos', '2023-04-18 15:42:50', '2023-04-18 15:42:50'),
(180, 'browse_single-outbox', 'commercial management', '2023-05-26 09:53:32', '2023-05-26 09:53:32'),
(181, 'browse_massive-outbox', 'commercial management', '2023-05-26 09:53:58', '2023-05-26 09:53:58'),
(182, 'browse_my-processes', 'Mis Procesos', '2024-05-06 04:24:35', '2024-05-06 04:24:35'),
(183, 'browse_processes', 'Procesos', '2024-05-06 04:24:57', '2024-05-06 04:24:57'),
(184, 'browse_proposals', 'Propuestas', '2024-05-06 04:26:28', '2024-05-06 04:26:28'),
(185, 'browse_proposal-templates', 'Propuestas', '2024-05-06 04:26:54', '2024-05-06 04:26:54');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permission_role`
--

CREATE TABLE `permission_role` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `permission_role`
--

INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES
(1, 1),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(31, 5),
(31, 6),
(32, 1),
(32, 5),
(32, 6),
(33, 1),
(33, 5),
(33, 6),
(34, 1),
(34, 5),
(34, 6),
(35, 3),
(37, 1),
(38, 1),
(39, 1),
(40, 1),
(41, 1),
(42, 1),
(42, 5),
(43, 1),
(43, 5),
(44, 1),
(44, 5),
(45, 1),
(45, 5),
(46, 1),
(46, 5),
(47, 1),
(47, 5),
(48, 1),
(48, 5),
(49, 1),
(49, 5),
(50, 1),
(50, 5),
(51, 1),
(51, 5),
(52, 1),
(52, 5),
(53, 1),
(53, 5),
(54, 1),
(54, 6),
(55, 1),
(56, 1),
(57, 1),
(58, 1),
(59, 1),
(70, 1),
(70, 5),
(71, 3),
(112, 1),
(113, 1),
(114, 1),
(115, 1),
(116, 1),
(117, 1),
(118, 1),
(119, 1),
(120, 1),
(121, 1),
(122, 1),
(123, 1),
(124, 1),
(125, 1),
(126, 1),
(127, 4),
(127, 7),
(129, 1),
(129, 6),
(131, 1),
(132, 1),
(133, 1),
(134, 1),
(135, 1),
(137, 1),
(138, 1),
(139, 1),
(140, 1),
(141, 1),
(143, 1),
(144, 1),
(145, 1),
(146, 1),
(147, 1),
(148, 1),
(149, 1),
(150, 1),
(151, 1),
(152, 1),
(158, 1),
(159, 1),
(160, 1),
(161, 1),
(162, 1),
(163, 1),
(164, 1),
(165, 1),
(166, 1),
(167, 1),
(168, 1),
(169, 1),
(170, 1),
(171, 1),
(172, 1),
(179, 1),
(179, 6),
(180, 1),
(180, 5),
(181, 1),
(181, 5),
(182, 4),
(182, 7),
(183, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presential_activities`
--

CREATE TABLE `presential_activities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `hour` time NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `facilitator` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `duration` int(11) NOT NULL,
  `registration_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `virtual_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `points` int(11) DEFAULT NULL,
  `step_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `reminder_message` text COLLATE utf8mb4_unicode_ci,
  `reminder_message_date` date DEFAULT NULL,
  `reminder_message_mean` text COLLATE utf8mb4_unicode_ci,
  `congratulation_message` text COLLATE utf8mb4_unicode_ci,
  `congratulation_message_date` date DEFAULT NULL,
  `congratulation_message_mean` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `presential_activities`
--

INSERT INTO `presential_activities` (`id`, `name`, `date`, `hour`, `location`, `facilitator`, `duration`, `registration_link`, `event_type`, `virtual_link`, `points`, `step_id`, `created_at`, `updated_at`, `reminder_message`, `reminder_message_date`, `reminder_message_mean`, `congratulation_message`, `congratulation_message_date`, `congratulation_message_mean`) VALUES
(1, 'Bootcamp Sesion 1', '2024-05-04', '23:51:00', 'ParqueSoft', 'Daniel', 120, 'www', 'virtual', 'aaa', NULL, 3, '2024-05-05 04:52:26', '2024-05-05 04:52:26', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presential_activities_groups`
--

CREATE TABLE `presential_activities_groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `hour` time NOT NULL,
  `quota` int(11) NOT NULL,
  `presential_activity_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `presential_activities_groups`
--

INSERT INTO `presential_activities_groups` (`id`, `name`, `date`, `hour`, `quota`, `presential_activity_id`, `created_at`, `updated_at`) VALUES
(1, 'Mañana', '2024-05-07', '10:00:00', 10, 1, '2024-05-07 20:44:28', '2024-05-07 20:44:28');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `problems`
--

CREATE TABLE `problems` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci,
  `description` text COLLATE utf8mb4_unicode_ci,
  `project_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `user_id` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `processes`
--

CREATE TABLE `processes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `processes`
--

INSERT INTO `processes` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Vuelo por la aceleracion', 'Es un programa de 3 etapas a desarrollarse por la Cámara de Comercio de Pasto en conjunto con\nParqueSoft Nariño y que tiene como fin llevar a un número de emprendedores a través de varias etapas\nque permitan mejorar sus habilidades cómo emprendedor, generar iniciativas innovadoras, potenciarlas\ncon herramientas digitales y acelerar su estrategia de comercialización, a través de sesiones de:\nFormación, Talleres, Bootcamps, Ferias de Digitalización', '2024-04-08 20:39:09', '2024-04-26 05:41:45');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products_services`
--

CREATE TABLE `products_services` (
  `id` int(10) UNSIGNED NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `development_level_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `beneficiaries` text COLLATE utf8mb4_unicode_ci,
  `contact_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products_services_files`
--

CREATE TABLE `products_services_files` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_service_id` int(11) DEFAULT NULL,
  `name` text COLLATE utf8mb4_unicode_ci,
  `url` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `projects`
--

CREATE TABLE `projects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `contact_id` int(11) DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `announcement_contact_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proposal_templates`
--

CREATE TABLE `proposal_templates` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `url_file` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proposal_templates_questions`
--

CREATE TABLE `proposal_templates_questions` (
  `id` int(10) UNSIGNED NOT NULL,
  `question` text COLLATE utf8mb4_unicode_ci,
  `proposal_template_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `name`, `display_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Administrator', '2022-12-29 08:33:07', '2022-12-29 08:33:07'),
(3, 'agent', 'Agente de contacto', '2023-01-23 14:27:27', '2023-01-23 14:28:34'),
(4, 'guest', 'Invitado', '2023-03-04 09:32:04', '2023-03-04 09:32:04'),
(5, 'commercial coordinator', 'Coordinador Comercial', '2023-03-04 09:32:57', '2023-03-04 09:32:57'),
(6, 'project coordinator', 'Coordinador De Proyectos', '2023-03-04 09:33:22', '2023-03-04 09:33:22'),
(7, 'company', 'Empresa', '2023-03-06 14:38:54', '2023-03-06 14:38:54');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `scalings`
--

CREATE TABLE `scalings` (
  `id` int(10) UNSIGNED NOT NULL,
  `regulations` text COLLATE utf8mb4_unicode_ci,
  `market` json DEFAULT NULL,
  `units_economics` text COLLATE utf8mb4_unicode_ci,
  `traction` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `project_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `settings`
--

CREATE TABLE `settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `details` text COLLATE utf8mb4_unicode_ci,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` int(11) NOT NULL DEFAULT '1',
  `group` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `settings`
--

INSERT INTO `settings` (`id`, `key`, `display_name`, `value`, `details`, `type`, `order`, `group`) VALUES
(1, 'site.title', 'Site Title', 'Site Title', '', 'text', 1, 'Site'),
(2, 'site.description', 'Site Description', 'Site Description', '', 'text', 2, 'Site'),
(3, 'site.logo', 'Site Logo', '', '', 'image', 3, 'Site'),
(4, 'site.google_analytics_tracking_id', 'Google Analytics Tracking ID', NULL, '', 'text', 4, 'Site'),
(5, 'admin.bg_image', 'Admin Background Image', 'settings\\May2024\\S3VgeC5BNY9Z0KqWd2E3.jpg', '', 'image', 5, 'Admin'),
(6, 'admin.title', 'Admin Title', 'Nido de Saberes', '', 'text', 1, 'Admin'),
(7, 'admin.description', 'Admin Description', 'Plataforma Nido de Saberes', '', 'text', 2, 'Admin'),
(8, 'admin.loader', 'Admin Loader', 'settings\\May2024\\6cuRNXd9hyY3fOeSo6VM.png', '', 'image', 3, 'Admin'),
(9, 'admin.icon_image', 'Admin Icon Image', 'settings\\May2024\\k5sriCh9RTvd5NWk69FX.png', '', 'image', 4, 'Admin'),
(10, 'admin.google_analytics_client_id', 'Google Analytics Client ID (used for admin dashboard)', NULL, '', 'text', 1, 'Admin'),
(11, 'site.front_header', 'front_header', NULL, NULL, 'code_editor', 6, 'Site'),
(12, 'site.front_hero', 'front_hero', NULL, NULL, 'code_editor', 7, 'Site'),
(13, 'site.front_body', 'front_body', '<div class=\"row d-flex align-items-center\" style=\"height: 100vh;\">\r\n    <div class=\"col-sm-12 col-md-6 mx-auto\">\r\n        @if (session()->has(\'message\'))\r\n        <div class=\"alert alert-success\">\r\n            {{ session(\'message\') }}\r\n        </div>\r\n        @endif\r\n        <img src=\"{{ asset(\'assets/img/banner-primer.png\') }}\" width=\"100%\"\r\n            style=\"margin-bottom: 5px; border-radius:10px\">\r\n        <div class=\"card\">\r\n            <div class=\"card-body\">\r\n                <h4 class=\"card-title\" style=\"color:#616161\">PRIMER CLOUD<h5>\r\n                        <h6 class=\"card-text\" style=\"color:#8b8b8b\">¡Bienvenido! Por favor, seleccione una\r\n                            opción:</h6>\r\n                        <a type=\"button\" href=\"{{ route(\'voyager.login\') }}\" class=\"btn-login\"\r\n                            style=\"text-decoration: none; font-weight:bold\">Ingresar</a>\r\n                        <a type=\"button\" href=\"{{ route(\'signup\') }}\"\r\n                            style=\"text-decoration: none; font-weight:bold\"\r\n                            class=\"btn-register\">Registrarme</a>\r\n            </div>\r\n        </div>\r\n    </div>\r\n</div>', NULL, 'code_editor', 8, 'Site'),
(14, 'site.front_footer', 'front_footer', NULL, NULL, 'code_editor', 9, 'Site'),
(15, 'site.front_javascript_header', 'front_javascript_header', NULL, NULL, 'code_editor', 10, 'Site'),
(16, 'site.front_javascript_post_html', 'front_javascript_post_html', NULL, NULL, 'code_editor', 11, 'Site'),
(17, 'site.front_css_header', 'front_css_header', NULL, NULL, 'code_editor', 12, 'Site');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `social_engineering_answers`
--

CREATE TABLE `social_engineering_answers` (
  `id` int(10) UNSIGNED NOT NULL,
  `contact_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `question_1` text COLLATE utf8mb4_unicode_ci,
  `question_2` text COLLATE utf8mb4_unicode_ci,
  `question_3` text COLLATE utf8mb4_unicode_ci,
  `question_4` text COLLATE utf8mb4_unicode_ci,
  `question_5` text COLLATE utf8mb4_unicode_ci,
  `question_6` text COLLATE utf8mb4_unicode_ci,
  `question_7` text COLLATE utf8mb4_unicode_ci,
  `question_8` text COLLATE utf8mb4_unicode_ci,
  `question_9` text COLLATE utf8mb4_unicode_ci,
  `question_10` text COLLATE utf8mb4_unicode_ci,
  `question_11` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `social_questions`
--

CREATE TABLE `social_questions` (
  `id` int(10) UNSIGNED NOT NULL,
  `question` text COLLATE utf8mb4_unicode_ci,
  `visibility` char(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `commercial_action_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solutions`
--

CREATE TABLE `solutions` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `problem_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `stages`
--

CREATE TABLE `stages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `process_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `stages`
--

INSERT INTO `stages` (`id`, `name`, `description`, `process_id`, `created_at`, `updated_at`) VALUES
(6, 'Emprendimiento', 'Etapa 1. Emprendimiento', 1, '2024-04-17 21:13:06', '2024-04-26 05:45:55'),
(7, 'Innovación', 'Etapa 2: Innovación', 1, '2024-04-26 05:45:35', '2024-04-26 05:45:35'),
(8, 'Digitalización', 'Etapa 3: Digitalización', 1, '2024-04-26 05:46:18', '2024-04-26 05:46:18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `steps`
--

CREATE TABLE `steps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `step_type` enum('F','M','CD','FAA','LMS') COLLATE utf8mb4_unicode_ci NOT NULL,
  `stage_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `steps`
--

INSERT INTO `steps` (`id`, `name`, `description`, `step_type`, `stage_id`, `created_at`, `updated_at`) VALUES
(1, 'Diagnostico ', 'Formulario de diagnóstico para caracterización e identificación del estado de sus \nemprendimiento', 'F', 6, '2024-04-22 20:07:41', '2024-04-22 20:07:41'),
(2, 'Reto informacion de la empresa', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit egestas fermentum, rhoncus integer morbi. Ultrices lacinia blandit himenaeos etiam accumsan phasellus mattis fermentum sociis pellentesque suscipit litora ullamcorper, quisque velit integer cursus sapien morbi eget sed cras id torquent rhoncus. Tristique interdum ut fames id hendrerit, aenean pharetra dictum potenti donec, cursus nam consequat tellus.\n\nPellentesque tristique conubia facilisi pharetra suspendisse mus, condimentum bibendum vivamus dui litora ut congue, tortor felis montes luctus pulvinar. Leo molestie ultrices pretium mattis nisi fames aenean felis bibendum aliquam tempus, mollis class aptent cubilia parturient quisque maecenas ridiculus pharetra sem. Iaculis ultrices vivamus pharetra arcu blandit integer vel odio, eu et penatibus a nam curae tristique metus parturient, ad accumsan ultricies dui massa quam quis.', 'CD', 6, '2024-04-22 21:36:26', '2024-05-02 15:12:48'),
(3, 'Bootcamp', 'Lorem ipsum dolor sit amet consectetur adipiscing elit, maecenas netus magnis gravida erat tellus, praesent sollicitudin eu non tortor proin. Egestas himenaeos aptent ornare magnis orci tempus gravida nullam, mus quam enim aliquam class lacus tristique lectus, convallis porta lobortis eros id sollicitudin erat. Conubia interdum curabitur taciti fames torquent ut dignissim egestas, primis mauris ridiculus porttitor cum dapibus tristique pretium leo, condimentum euismod fringilla nullam luctus aliquet convallis.\n\nSuspendisse cursus facilisis primis cum hac cras magna sociosqu lacus habitasse diam dapibus, vitae duis tempor tristique ante ligula ut mi eu euismod. Tortor conubia class risus posuere diam ultrices aliquam at integer urna, nisl vestibulum semper dui malesuada metus nullam libero purus sollicitudin, quis aptent orci mollis torquent magna vitae quisque lacus. Leo felis velit morbi eros inceptos porta pretium congue odio nulla blandit orci, curabitur ridiculus nisi interdum dictum sem cras placerat ligula dapibus mus.', 'FAA', 6, '2024-05-05 04:43:14', '2024-05-05 04:43:14'),
(4, 'Mentorias', 'Lorem ipsum dolor sit amet consectetur adipiscing elit potenti, sed vehicula parturient scelerisque et conubia magna, fusce per enim vulputate nunc est sagittis. Elementum hac sociis ac per class congue rhoncus, ante urna lectus enim viverra mollis fermentum nibh, metus montes vitae hendrerit posuere massa. Vehicula aliquet facilisi molestie natoque maecenas erat viverra ligula phasellus lacinia curae, neque ad dignissim nam sagittis vitae cras consequat class hac, primis mollis ornare justo scelerisque orci dictum non imperdiet sodales.\n\nPenatibus aliquam faucibus vel semper sociosqu morbi feugiat, inceptos vitae dignissim tristique euismod duis massa aenean, class non ultrices nascetur nibh neque. Placerat mattis in tempus sodales nisl platea neque curabitur, pulvinar luctus dapibus libero class ornare cursus convallis, elementum aenean arcu erat pretium dictumst quisque. Quis ac torquent praesent auctor ut euismod non vestibulum luctus, semper et elementum phasellus aliquet ad parturient cum.', 'M', 6, '2024-05-06 06:14:40', '2024-05-06 06:14:40'),
(5, 'LMS', 'Lorem ipsum dolor sit amet consectetur adipiscing elit placerat, tristique in suscipit proin risus ante sociosqu parturient, scelerisque sagittis per gravida nec aliquet conubia. Mattis maecenas urna massa eleifend nisi lacinia varius malesuada erat, dignissim senectus dapibus eu tincidunt purus pellentesque phasellus. Dui tortor nam rhoncus conubia ligula dictumst tristique cubilia porta, nulla augue ac nascetur dictum cursus hendrerit.\n\nEget nostra convallis erat cubilia iaculis varius nisl velit aptent, mollis rhoncus ad ultricies at donec laoreet blandit. Tempor neque est cursus gravida vestibulum mollis mus condimentum aptent cubilia hac, nascetur proin parturient dapibus blandit felis scelerisque fames augue. Cras suscipit augue sem hac velit, lectus porttitor non malesuada purus nullam, eu praesent torquent urna.', 'LMS', 6, '2024-05-06 14:45:37', '2024-05-06 14:45:37');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `supports`
--

CREATE TABLE `supports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `subject` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci,
  `support_attached` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_supports_id` int(11) DEFAULT NULL,
  `level_support` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state_support` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `support_user_id` int(11) NOT NULL,
  `date_support` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `supports`
--

INSERT INTO `supports` (`id`, `subject`, `slug`, `body`, `support_attached`, `category_supports_id`, `level_support`, `state_support`, `support_user_id`, `date_support`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 'No me permite crear usuarios administradores', 'no-me-permite-crear-usuarios-administradores', '<p>El sistema no deja registrar nuevos usuarios administradores</p>\r\n', 'public/support/gGN846Fza6tR3gbKYTDbsDo1D39y4TXem01vfJto.jpg', 1, NULL, 'solicitado', 1, '2023-05-19 11:12:06', '2023-05-17 17:20:03', '2023-05-19 11:12:06', NULL),
(3, 'Soporte de usuario prueba', 'soporte-de-usuario-prueba', '<p><strong>Soporte de usuario prueba</strong></p>\n', NULL, 1, 'bajo', 'desarrollo', 1, '2023-05-19 11:48:50', '2023-05-18 17:23:53', '2023-05-19 11:48:50', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `supports_responses`
--

CREATE TABLE `supports_responses` (
  `id` int(10) UNSIGNED NOT NULL,
  `body_response` text COLLATE utf8mb4_unicode_ci,
  `response_attached` text COLLATE utf8mb4_unicode_ci,
  `date_response` datetime DEFAULT NULL,
  `response_user_id` int(11) DEFAULT NULL,
  `support_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tasks_contacts`
--

CREATE TABLE `tasks_contacts` (
  `id` int(10) UNSIGNED NOT NULL,
  `task_id` int(11) DEFAULT NULL,
  `assigned_to` int(11) DEFAULT NULL,
  `contact_id` int(11) DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `task_date_start` date DEFAULT NULL,
  `task_time_start` time DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `task_observations` text COLLATE utf8mb4_unicode_ci,
  `assigned_by` int(11) DEFAULT NULL,
  `task_date_completed` date DEFAULT NULL,
  `task_time_completed` time DEFAULT NULL,
  `task_observations_completed` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `task_date_end` date DEFAULT NULL,
  `task_time_end` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tasks_types`
--

CREATE TABLE `tasks_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `technologies`
--

CREATE TABLE `technologies` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `technologies`
--

INSERT INTO `technologies` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'IoT', NULL, NULL, NULL),
(2, 'Data analytics', NULL, NULL, NULL),
(3, 'AI', NULL, NULL, NULL),
(4, 'Robótica', '2023-04-20 13:31:46', '2023-04-20 13:31:46', NULL),
(5, 'Biotecnología', '2023-04-20 13:31:59', '2023-04-20 13:31:59', NULL),
(6, 'Energías renovables', '2023-04-20 13:32:09', '2023-04-20 13:32:09', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `topics`
--

CREATE TABLE `topics` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `topics`
--

INSERT INTO `topics` (`id`, `name`, `description`, `course_id`, `created_at`, `updated_at`) VALUES
(1, 'Introduccion', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 2, '2024-04-16 20:39:00', '2024-04-16 20:39:00'),
(2, 'Tema 1', 'Lorem ipsum dolor sit amet consectetur adipiscing elit placerat, tristique in suscipit proin risus ante sociosqu parturient, scelerisque sagittis per gravida nec aliquet conubia. Mattis maecenas urna massa eleifend nisi lacinia varius malesuada erat, dignissim senectus dapibus eu tincidunt purus pellentesque phasellus. Dui tortor nam rhoncus conubia ligula dictumst tristique cubilia porta, nulla augue ac nascetur dictum cursus hendrerit.\n', 3, '2024-05-06 14:48:01', '2024-05-06 20:35:01'),
(3, 'Etapa 1', 'Lorem ipsum dolor sit amet consectetur adipiscing elit magna imperdiet, habitasse quam leo donec posuere suspendisse parturient integer augue faucibus, cura', 3, '2024-05-06 20:47:33', '2024-05-06 20:47:33');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `translations`
--

CREATE TABLE `translations` (
  `id` int(10) UNSIGNED NOT NULL,
  `table_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `column_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foreign_key` int(10) UNSIGNED NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tutorials`
--

CREATE TABLE `tutorials` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `category_tutorials_id` int(11) NOT NULL,
  `create_user_id` int(11) NOT NULL,
  `update_user_id` int(11) DEFAULT NULL,
  `state` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attached` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `embed` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tutorials`
--

INSERT INTO `tutorials` (`id`, `title`, `slug`, `description`, `category_tutorials_id`, `create_user_id`, `update_user_id`, `state`, `attached`, `embed`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Registro de usuario.', 'registro-de-usuario', '<p>Video para aprender a realizar el registro de usuarios.</p>\n', 1, 1, 1, 'borrador', '[]', '<p><iframe title=\"YouTube video player\" src=\"https://www.youtube.com/embed/oiuzB1c9Bi0\" width=\"560\" height=\"315\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" allowfullscreen=\"allowfullscreen\"></iframe></p>', '2023-04-03 19:33:14', '2023-05-18 11:45:25', NULL),
(2, 'Manual de verificación de viabilidad', 'manual-de-verificacion-de-viabilidad', '<p>Explicar&nbsp;</p>', 1, 1, 1, 'borrador', '[{\"download_link\":\"tutorials\\/April2023\\/NPy5U2cRqh52RKMRQpUL.pdf\",\"original_name\":\"1formulacion-de-afiliacion-VERSION-7.pdf\"}]', '<p><iframe title=\"YouTube video player\" src=\"https://www.youtube.com/embed/8rRdfWE1GAM\" width=\"560\" height=\"315\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" allowfullscreen=\"allowfullscreen\"></iframe></p>', '2023-04-20 13:27:09', '2023-04-20 13:27:09', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'users/default.png',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `settings` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `role_id`, `name`, `email`, `avatar`, `email_verified_at`, `password`, `remember_token`, `settings`, `created_at`, `updated_at`) VALUES
(1, 1, 'Administrador', 'admin@primer.com', 'users\\May2024\\ibEG56Znk3K2RurI2HC3.png', NULL, '$2y$10$4w9c.3zpSP.cNV8Fkdb8cO0Bydx/Z3L4rwOf7D3knT6cqMcEVyihC', 'dZjcVNqNGDLBikfhV9dZrGIRxe8Bh4eMWZIJuwrUlcbDUD4QN5g8ZBxAOto7', '{\"locale\":\"es\"}', '2022-12-29 08:33:47', '2024-05-06 04:32:25'),
(3, 3, 'Agente de contacto 2', 'agente2@primer.com', 'users/default.png', NULL, '$2y$10$iN9yAX1TnaPLJpnXNdZYrOp/Dc9DV7TwsUMbkFX2h13XYsGc35xgu', '6RucPEMv902xOvwxZRYKZl5BG1sUgJpyEQ9jXRoOkdAdr136tN7dR584I3lO', '{\"locale\":\"es\"}', '2023-02-06 19:22:42', '2023-02-24 11:48:41'),
(4, 3, 'Agente de contacto 3', 'agente3@primer.com', 'users/default.png', NULL, '$2y$10$NzZ.jt2Yz6.GmXDOHAIT4ui/KihEeUJN0YyZ4sxhxf1lAVeNjE8Fm', NULL, '{\"locale\":\"es\"}', '2023-02-06 19:22:58', '2023-02-24 11:48:49'),
(5, 5, 'Coordinador comerical', 'comercial@primer.com', 'users/default.png', NULL, '$2y$10$BmYMB6IzyyJk.DEriKo.L.YXrbR0tndUm7lULJUDl/fpW1xiynzxu', NULL, '{\"locale\":\"es\"}', '2023-03-04 10:30:47', '2023-03-04 10:30:47'),
(6, 6, 'Coordinador de proyectos', 'proyectos@primer.com', 'users/default.png', NULL, '$2y$10$2NTVN3YKs/x9HEWqSE3smOEU0VnfW5C8yT6ngXJiIiMUsgnR5vewm', 'LJAbpjtxcnviQEhdstYz6SPO38WpeaKHAuc692Lo6vPsNk2pHZBXFiijk2Bn', '{\"locale\":\"es\"}', '2023-03-04 10:31:21', '2023-03-04 10:31:21'),
(7, 7, 'Empresario', 'empresario@primer.com', 'users/default.png', NULL, '$2y$10$3DThJmIbL2uv7tzwel2DVeRwVvpOgAfycQJh6.hQu4w6BqPC7uo/C', 'P1BlSoL7Pv6toJHCnPyc0uC3FxmOBXSzDJdNfg8MH5MB2kjN6dFJyv2NpyI9', '{\"locale\":\"es\"}', '2023-03-06 09:58:11', '2023-03-06 14:39:11'),
(8, 4, 'Ejemplo invitado', 'ejemploinvitado@primer.com', 'users/default.png', NULL, '$2y$10$8bzORFTvzeFCoRy2Cq3zM.Cz1Hpt1ctkuGCmTGbDovHAtmMuIpZN2', NULL, '{\"locale\":\"es\"}', '2023-03-06 10:37:19', '2023-03-14 07:37:50'),
(9, 7, 'ParqueSoft Crea SAS', 'info@parquecrea.com', 'users/default.png', NULL, '$2y$10$Zvig8rFA86R397F8eE0G2uaXCySrajH05d/jTv1YV1HoWQM0RLL1q', NULL, '{\"locale\":\"es\"}', '2023-03-06 13:59:16', '2023-03-06 14:41:51'),
(10, 7, 'Empresa Prueba Genval', 'genval@primer.com.co', 'users/default.png', NULL, '$2y$10$GEvkIuimxkSLMteJb9/Ha.3h2VEor5j7aKNuPr3e8yH8oB91f77MW', NULL, '{\"locale\":\"es\"}', '2023-03-06 14:11:37', '2023-03-06 14:41:59'),
(11, 7, 'Agua Brisa', 'brisa@aguas.com', 'users/default.png', NULL, '$2y$10$dIlNgZ11JP7ixn1DZxpGdeA7O0weSARVpb4sKycdQ5eERVqvG135C', 'aSf7Tu5pzRVWhaXvYnJcJqHtQC3Ch0QmthtkSh4031rzbTHFI6Do10hoVwmu', '{\"locale\":\"es\"}', '2023-03-21 15:56:18', '2023-03-21 15:58:21'),
(12, 7, 'Empresa SAS', 'sas@mail.com', 'users/default.png', NULL, '$2y$10$4ojkxvRWxyM2nQsFltEJx.BGcAffMKTMxyRO6HYszkQioGE.okM32', NULL, NULL, '2023-03-23 17:00:43', '2023-03-23 17:30:02'),
(13, 7, 'Ringo Monerias', 'ringomonerias@gmail.com', 'users/default.png', NULL, '$2y$10$Z71o/JpHWeHyztES5U0Xf./k2StquiwzB.SxdTflhnYCU5h8iWh7K', NULL, NULL, '2023-03-27 17:46:34', '2023-03-27 17:47:05'),
(14, 7, 'Empresa de prueba', 'prueba@gmail.com', 'users/default.png', NULL, '$2y$10$Y2WXAvUmHj0iNlQOJaVOm.QDQcgvEGvymkp52Y0Z2HVMPcQE4paDa', 'TTwo18UfDB6InwbwfZQAqMfqMJVc4HVclvZWvzd2hjoEDalSZugXrfnq3yiI', NULL, '2023-04-01 23:14:18', '2023-04-01 23:16:20'),
(15, 4, 'Example Company', 'example@mail.com', 'users/default.png', NULL, '$2y$10$EWXQvgVNmHGtmiZtv3Zm3.gT4j52bgVW5B2PjCycvpLzuTbLhqg.a', 'KALbfj0brDyK63uJm0UpDqwhZcDgZ5NNIu79t4IO8q0o4Men2gEWwglrtJrB', '{\"locale\":\"es\"}', '2023-04-11 14:48:47', '2023-04-12 07:35:26'),
(16, 3, 'Agente Contacto', 'agentecontacto@primercloud.com', 'users/April2023/NVXFFmj6u5Wa24gVWtQ2.png', NULL, '$2y$10$aRjLa8lDkIfdb4mtHO2MzOIemCNz/986dHCKm0BCoTy76G6WJMfMy', NULL, '{\"locale\":\"es\"}', '2023-04-12 16:32:54', '2023-04-12 16:32:54'),
(17, 1, 'Administrador', 'administrador@primercloud.com', 'users/April2023/I960N039Bt5BroXjiH1I.png', NULL, '$2y$10$aZojUYhaXd.u89f3dMEssOrlvDSMhbzXnzAni.7XGKkh64RV7ov5.', 'hMlJHhCyJzkW5BCmtjPSsTIfBo6Q2GfPsAYOU4Y5ej2r96iGv63ZniveWhQv', '{\"locale\":\"es\"}', '2023-04-12 16:34:57', '2023-04-12 16:34:57'),
(18, 5, 'Co Comercial', 'comercial@primercloud.com', 'users/April2023/16w2wHOT2ofenHo6XD4C.png', NULL, '$2y$10$BKncnZ3sgguapNNRc.sROefB3a0CSBF.9aSeZcANY3z3LnxY8O2Ga', '4NqMPSYymWx1CzLbeuKluvYuq8f2uT6eullWl21q82PDVatVrm7nqlYQgcCB', '{\"locale\":\"es\"}', '2023-04-12 16:35:52', '2023-04-12 16:35:52'),
(19, 6, 'Co Proyectos', 'proyectos@primercloud.com', 'users/April2023/tVOSkBQjvNWyF5oD2ouj.png', NULL, '$2y$10$yd8HGTGCGZYf4m7CdF/zpeUK6JPZhIq075S5dK1IgQXHDjCJr4JgW', NULL, '{\"locale\":\"es\"}', '2023-04-12 16:36:57', '2023-04-12 16:36:57'),
(20, 7, 'SoftCorp', 'softcorp@gmail.com', 'users/default.png', NULL, '$2y$10$HCfrIeSBkkCuetwkbhObiukcdg3Oh9zZZPc.m3YlgnKZuTGpysF8O', 'EmCcp5ENDNcuaJblaDEXDuQOEOXgYtzN63AsmOxlA0UnUWkk85b6vLhqD2J6', NULL, '2023-04-12 16:38:08', '2023-04-12 16:38:55'),
(21, 7, 'NaturalTech', 'naturaltech@gmail.com', 'users/default.png', NULL, '$2y$10$3X0DDlYbpoyGFp4nhC4NueuAB/4n8RJXSIHkU.teZJ/mE3yWmkrz.', NULL, NULL, '2023-04-12 16:41:38', '2024-02-12 15:31:33'),
(22, 4, 'Quant finance SAS', 'cio@quantfinancesas.com', 'users/default.png', NULL, '$2y$10$.j1P0.sYS6xAylxytnldxuv1KsfwtyIGhJWk.yPQ//EkUFHU2Vn8m', NULL, NULL, '2023-04-12 17:38:24', '2023-04-12 17:38:24'),
(23, 4, 'Prueba s.a.s', 'entorno@entorno.com', 'users/default.png', NULL, '$2y$10$oa0zFQgyoaq2JFeod189zOnF3s5WOaJbnin7y1mI0Wxk6.5CwmvWS', NULL, NULL, '2023-04-13 16:00:58', '2023-04-13 16:00:58'),
(24, 7, 'Empresa ficticia', 'ficticia@gmail.com', 'users/default.png', NULL, '$2y$10$wTbGhO1n4IR.x4o9tf1LC.hdGWEuz7JzueDF0kBTOnhYh/QoAMtRO', NULL, NULL, '2023-04-20 11:28:50', '2023-04-20 12:07:19'),
(25, 7, 'Coltejer', 'coltejer@gmail.com', 'users/default.png', NULL, '$2y$10$h102fG25K1DbKE5Otgvg5uvopbHtfpqCLHHEwygmLZqken4oqN4Xy', NULL, '{\"locale\":\"es\"}', '2023-04-20 14:33:04', '2023-10-28 13:34:21'),
(26, 7, 'Primer', 'carolina@primer.com.co', 'users/default.png', NULL, '$2y$10$VaNJ3F5oFhafapTSHEX00edpWozZ70v60DKQWTC/tpNXYiOaF57VC', 'dMGCDNxDpfhnRwbNvP9TUjeXFKFGbv9EJcu2URMyur2KkWmb9A7BJQEsakEc', NULL, '2023-05-06 13:29:15', '2023-05-06 15:58:23'),
(27, 4, 'prueba angie', 'angie@primer.com.co', 'users/default.png', NULL, '$2y$10$uB89srfXQO4lFCAKkC3YRuCgOo/e9upPwwQP/xKDVjBDAWpNbfP9S', NULL, NULL, '2023-05-09 10:50:27', '2023-05-09 10:50:27'),
(28, 7, 'Ecoflora', 'gerencia@ecofloracares.com', 'users/default.png', NULL, '$2y$10$/pERXGuy7EQQH3IszONoouaOjaBqhMC4DpbXTObttAoZxxoDuutxy', 'VtnlWX53YWZSyhlmbf1JhOStsBD1h7KilUHAQyP2WIVMdKKa9nxQV9DYeM6Y', NULL, '2023-05-10 14:39:47', '2023-05-10 14:45:14'),
(29, 7, 'Example User', 'user@mail.com', 'users/default.png', NULL, '$2y$10$PyBfzqxBR3KVVXEUBnzCR.gCWbHpla9qkXWSLXSO.BZvhh7be9ukS', 'k15XcVhU7QcZLyf0kQ3PrMYOLNbETwB72FZAbEr5m81p1oNKxWujSbrYtJRw', NULL, '2023-05-15 14:47:27', '2023-05-15 14:47:27'),
(34, 4, 'prueba 3 angie', 'angiie.amorocho42@gmail.com', 'users/default.png', NULL, '$2y$10$bl29XW669Fs2/poaXGTsdO.e.p/3D4TN8YTTOQRXjdetNs.oX/oeq', NULL, NULL, '2023-05-18 15:47:40', '2023-05-18 15:47:40'),
(47, 7, 'Examplex', 'duckermusic@gmail.com', 'users/default.png', NULL, '$2y$10$lVaPgdWhOIwR.MrNFf0ByuWQCKaJtLrAAyOTzw9lK7NlMxh63zq2e', NULL, NULL, '2023-05-26 10:47:51', '2023-05-26 10:47:51'),
(48, 7, 'Prueba Convergencia', 'convergencia@gmail.com', 'users/default.png', NULL, '$2y$10$XwCdav7FPuynR6Lqaa1zrupqNCodTeRaxghpK7O65C4h5HlE5QIPy', NULL, NULL, '2023-06-03 22:33:13', '2023-06-03 22:47:00'),
(49, 7, 'Prueba 1', 'prueba1@gmail.com', 'users/default.png', NULL, '$2y$10$Xugx7dE0eh145lbub52bX.Ylsu9KvwigNrfMLCgehToGvTYEqYDd.', NULL, NULL, '2023-06-03 22:53:30', '2023-06-03 22:53:30'),
(50, 7, 'Prueba 2', 'prueba2@gmail.com', 'users/default.png', NULL, '$2y$10$SMOnsKfo9wuE7mcWag38mezDD/Kt5VZ7wZGNIFUlafpJBw9/CSNAu', NULL, NULL, '2023-06-03 22:58:22', '2023-06-03 22:58:22'),
(51, 7, 'Camilin', 'camilopinguin@gmail.com', 'users/default.png', NULL, '$2y$10$tIOAIO.FG1r10gJT9qL6NOGQw4OBn3yviCp8oW5CaFwYEm866QW8K', NULL, NULL, '2023-10-28 12:35:13', '2023-10-28 12:35:13'),
(52, 7, 'JIHNA Solutions', 'jihna@solutions.com', 'users/default.png', NULL, '$2y$10$Ezepm0.7QJrvHmeVUsViD.gOu4q54fSTilL7jK54ivntjLwkls4Va', NULL, NULL, '2023-11-03 17:19:43', '2023-11-03 17:20:36'),
(53, 7, 'NathaSocio', 'ncastillo@parquesoft.co', 'users/default.png', NULL, '$2y$10$HzH2/zMiVMy4ZNIlHRFs0eOD.mJA9bQfudktuDRUM8D0JtcTBuOhy', NULL, '{\"locale\":\"es\"}', '2024-01-16 16:38:35', '2024-01-16 16:41:15'),
(54, 7, 'Herney', 'herney@mail.com', 'users/default.png', NULL, '$2y$10$Tjlplv40CNWWYMkq68rQi.zMLRlf9OFyT4cRNpjVmonj/gnNRah32', NULL, NULL, '2024-04-18 20:24:28', '2024-04-18 20:24:28'),
(55, 7, 'Maria', 'danielcriollo9706@gmail.com', 'users/default.png', NULL, '$2y$10$y5rpTn6kBWuW.tZNaDIsau6Bn6AI/v.6j1xxCO/46lrtbMCEUecqG', NULL, NULL, '2024-04-19 20:57:58', '2024-04-19 20:57:58'),
(56, 7, 'Felipe', 'felix@mail.com', 'users/default.png', NULL, '$2y$10$XX.oALNrrXpNe4F34eovpuWHD6WUHLxMNz3c6WRzs4qci1K5BpK06', NULL, NULL, '2024-04-19 21:18:20', '2024-04-19 21:18:20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_roles`
--

CREATE TABLE `user_roles` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `agents`
--
ALTER TABLE `agents`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `announcements_contacts`
--
ALTER TABLE `announcements_contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `announcements_forms`
--
ALTER TABLE `announcements_forms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `announcement_id` (`announcement_id`),
  ADD KEY `commercial_form_id` (`commercial_form_id`);

--
-- Indices de la tabla `announcements_forms_options`
--
ALTER TABLE `announcements_forms_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `announcement_form_id` (`announcement_form_id`),
  ADD KEY `commercial_question_id` (`commercial_question_id`),
  ADD KEY `commercial_question_option_id` (`commercial_question_option_id`);

--
-- Indices de la tabla `answers_form_4`
--
ALTER TABLE `answers_form_4`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `answers_form_5`
--
ALTER TABLE `answers_form_5`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `answers_form_6`
--
ALTER TABLE `answers_form_6`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `answers_form_7`
--
ALTER TABLE `answers_form_7`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `answers_form_8`
--
ALTER TABLE `answers_form_8`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `answers_form_9`
--
ALTER TABLE `answers_form_9`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `answers_form_10`
--
ALTER TABLE `answers_form_10`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `answers_form_11`
--
ALTER TABLE `answers_form_11`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `answers_form_12`
--
ALTER TABLE `answers_form_12`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `answers_form_13`
--
ALTER TABLE `answers_form_13`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `business_models`
--
ALTER TABLE `business_models`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `campaigns`
--
ALTER TABLE `campaigns`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `campaign_contacts`
--
ALTER TABLE `campaign_contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `categoryfaqs`
--
ALTER TABLE `categoryfaqs`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `categorysupports`
--
ALTER TABLE `categorysupports`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `categorytutorials`
--
ALTER TABLE `categorytutorials`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `challenges`
--
ALTER TABLE `challenges`
  ADD PRIMARY KEY (`id`),
  ADD KEY `challenges_step_id_foreign` (`step_id`);

--
-- Indices de la tabla `commercial_actions`
--
ALTER TABLE `commercial_actions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `commercial_strategy_id` (`commercial_strategy_id`);

--
-- Indices de la tabla `commercial_forms`
--
ALTER TABLE `commercial_forms`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `commercial_form_actions`
--
ALTER TABLE `commercial_form_actions`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `commercial_form_options`
--
ALTER TABLE `commercial_form_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `commercial_form_question_id` (`commercial_form_question_id`);

--
-- Indices de la tabla `commercial_form_questions`
--
ALTER TABLE `commercial_form_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `commercial_form_id` (`commercial_form_id`);

--
-- Indices de la tabla `commercial_lands`
--
ALTER TABLE `commercial_lands`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `commercial_strategies`
--
ALTER TABLE `commercial_strategies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `commercial_land_id` (`commercial_land_id`);

--
-- Indices de la tabla `company_charges`
--
ALTER TABLE `company_charges`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `company_types`
--
ALTER TABLE `company_types`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `contacts_assigned_forms`
--
ALTER TABLE `contacts_assigned_forms`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `contacts_attachments`
--
ALTER TABLE `contacts_attachments`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `contacts_challenges`
--
ALTER TABLE `contacts_challenges`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `contacts_information_forms`
--
ALTER TABLE `contacts_information_forms`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `contacts_mentoring`
--
ALTER TABLE `contacts_mentoring`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `contacts_points_details`
--
ALTER TABLE `contacts_points_details`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `contacts_proposals`
--
ALTER TABLE `contacts_proposals`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `contacts_schedules`
--
ALTER TABLE `contacts_schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contact_id` (`contact_id`),
  ADD KEY `contacts_schedules_user_id_index` (`user_id`) USING BTREE;

--
-- Indices de la tabla `contacts_stages`
--
ALTER TABLE `contacts_stages`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `contracts_templates`
--
ALTER TABLE `contracts_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `courses_previous_course_foreign` (`previous_course`),
  ADD KEY `courses_next_course_foreign` (`next_course`);

--
-- Indices de la tabla `data_rows`
--
ALTER TABLE `data_rows`
  ADD PRIMARY KEY (`id`),
  ADD KEY `data_rows_data_type_id_foreign` (`data_type_id`);

--
-- Indices de la tabla `data_types`
--
ALTER TABLE `data_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `data_types_name_unique` (`name`),
  ADD UNIQUE KEY `data_types_slug_unique` (`slug`);

--
-- Indices de la tabla `development_levels`
--
ALTER TABLE `development_levels`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `economic_sectors`
--
ALTER TABLE `economic_sectors`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `email_templates`
--
ALTER TABLE `email_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `faqs_slug_unique` (`slug`);

--
-- Indices de la tabla `impacts`
--
ALTER TABLE `impacts`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `impacts_attachments`
--
ALTER TABLE `impacts_attachments`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `indicators`
--
ALTER TABLE `indicators`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `individual_emails`
--
ALTER TABLE `individual_emails`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `information_forms`
--
ALTER TABLE `information_forms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `information_forms_step_id_foreign` (`step_id`);

--
-- Indices de la tabla `information_forms_answers`
--
ALTER TABLE `information_forms_answers`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `information_form_options`
--
ALTER TABLE `information_form_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `information_form_options_information_form_question_id_foreign` (`information_form_question_id`);

--
-- Indices de la tabla `information_form_questions`
--
ALTER TABLE `information_form_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `information_form_questions_information_form_id_foreign` (`information_form_id`);

--
-- Indices de la tabla `innovations`
--
ALTER TABLE `innovations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indices de la tabla `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lessons_topic_id_foreign` (`topic_id`);

--
-- Indices de la tabla `meetings`
--
ALTER TABLE `meetings`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `memberships`
--
ALTER TABLE `memberships`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `mentors`
--
ALTER TABLE `mentors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mentors_email_unique` (`email`),
  ADD KEY `mentors_step_id_foreign` (`step_id`);

--
-- Indices de la tabla `mentor_availabilities`
--
ALTER TABLE `mentor_availabilities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mentor_availabilities_mentor_id_foreign` (`mentor_id`);

--
-- Indices de la tabla `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `menus_name_unique` (`name`);

--
-- Indices de la tabla `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_items_menu_id_foreign` (`menu_id`);

--
-- Indices de la tabla `message_templates`
--
ALTER TABLE `message_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `metodologies`
--
ALTER TABLE `metodologies`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indices de la tabla `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Indices de la tabla `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indices de la tabla `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indices de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indices de la tabla `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permissions_key_index` (`key`);

--
-- Indices de la tabla `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `permission_role_permission_id_index` (`permission_id`),
  ADD KEY `permission_role_role_id_index` (`role_id`);

--
-- Indices de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indices de la tabla `presential_activities`
--
ALTER TABLE `presential_activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `presential_activities_step_id_foreign` (`step_id`);

--
-- Indices de la tabla `presential_activities_groups`
--
ALTER TABLE `presential_activities_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `presential_activities_groups_presential_activity_id_foreign` (`presential_activity_id`);

--
-- Indices de la tabla `problems`
--
ALTER TABLE `problems`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `processes`
--
ALTER TABLE `processes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `products_services`
--
ALTER TABLE `products_services`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `products_services_files`
--
ALTER TABLE `products_services_files`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `proposal_templates`
--
ALTER TABLE `proposal_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `proposal_templates_questions`
--
ALTER TABLE `proposal_templates_questions`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indices de la tabla `scalings`
--
ALTER TABLE `scalings`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indices de la tabla `social_engineering_answers`
--
ALTER TABLE `social_engineering_answers`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `social_questions`
--
ALTER TABLE `social_questions`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `solutions`
--
ALTER TABLE `solutions`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `stages`
--
ALTER TABLE `stages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stages_process_id_foreign` (`process_id`);

--
-- Indices de la tabla `steps`
--
ALTER TABLE `steps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `steps_stage_id_foreign` (`stage_id`);

--
-- Indices de la tabla `supports`
--
ALTER TABLE `supports`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `supports_responses`
--
ALTER TABLE `supports_responses`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tasks_contacts`
--
ALTER TABLE `tasks_contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tasks_types`
--
ALTER TABLE `tasks_types`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `technologies`
--
ALTER TABLE `technologies`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `topics_course_id_foreign` (`course_id`);

--
-- Indices de la tabla `translations`
--
ALTER TABLE `translations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `translations_table_name_column_name_foreign_key_locale_unique` (`table_name`,`column_name`,`foreign_key`,`locale`);

--
-- Indices de la tabla `tutorials`
--
ALTER TABLE `tutorials`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tutorials_slug_unique` (`slug`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- Indices de la tabla `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `user_roles_role_id_index` (`role_id`),
  ADD KEY `user_roles_user_id_index` (`user_id`) USING BTREE;

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `agents`
--
ALTER TABLE `agents`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `announcements_contacts`
--
ALTER TABLE `announcements_contacts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `announcements_forms`
--
ALTER TABLE `announcements_forms`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `announcements_forms_options`
--
ALTER TABLE `announcements_forms_options`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `answers_form_4`
--
ALTER TABLE `answers_form_4`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `answers_form_5`
--
ALTER TABLE `answers_form_5`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `answers_form_6`
--
ALTER TABLE `answers_form_6`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `answers_form_7`
--
ALTER TABLE `answers_form_7`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `answers_form_8`
--
ALTER TABLE `answers_form_8`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `answers_form_9`
--
ALTER TABLE `answers_form_9`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `answers_form_10`
--
ALTER TABLE `answers_form_10`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `answers_form_11`
--
ALTER TABLE `answers_form_11`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `answers_form_12`
--
ALTER TABLE `answers_form_12`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `answers_form_13`
--
ALTER TABLE `answers_form_13`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `business_models`
--
ALTER TABLE `business_models`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `campaigns`
--
ALTER TABLE `campaigns`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `campaign_contacts`
--
ALTER TABLE `campaign_contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `categoryfaqs`
--
ALTER TABLE `categoryfaqs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `categorysupports`
--
ALTER TABLE `categorysupports`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `categorytutorials`
--
ALTER TABLE `categorytutorials`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `challenges`
--
ALTER TABLE `challenges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `commercial_actions`
--
ALTER TABLE `commercial_actions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `commercial_forms`
--
ALTER TABLE `commercial_forms`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `commercial_form_actions`
--
ALTER TABLE `commercial_form_actions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `commercial_form_options`
--
ALTER TABLE `commercial_form_options`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `commercial_form_questions`
--
ALTER TABLE `commercial_form_questions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT de la tabla `commercial_lands`
--
ALTER TABLE `commercial_lands`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `commercial_strategies`
--
ALTER TABLE `commercial_strategies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `company_charges`
--
ALTER TABLE `company_charges`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `company_types`
--
ALTER TABLE `company_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `contacts_assigned_forms`
--
ALTER TABLE `contacts_assigned_forms`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `contacts_attachments`
--
ALTER TABLE `contacts_attachments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `contacts_challenges`
--
ALTER TABLE `contacts_challenges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `contacts_information_forms`
--
ALTER TABLE `contacts_information_forms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `contacts_mentoring`
--
ALTER TABLE `contacts_mentoring`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `contacts_points_details`
--
ALTER TABLE `contacts_points_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `contacts_proposals`
--
ALTER TABLE `contacts_proposals`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `contacts_schedules`
--
ALTER TABLE `contacts_schedules`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `contacts_stages`
--
ALTER TABLE `contacts_stages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `contracts_templates`
--
ALTER TABLE `contracts_templates`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `courses`
--
ALTER TABLE `courses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `data_rows`
--
ALTER TABLE `data_rows`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=183;

--
-- AUTO_INCREMENT de la tabla `data_types`
--
ALTER TABLE `data_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `development_levels`
--
ALTER TABLE `development_levels`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `economic_sectors`
--
ALTER TABLE `economic_sectors`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `email_templates`
--
ALTER TABLE `email_templates`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `impacts`
--
ALTER TABLE `impacts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `impacts_attachments`
--
ALTER TABLE `impacts_attachments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `indicators`
--
ALTER TABLE `indicators`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `individual_emails`
--
ALTER TABLE `individual_emails`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `information_forms`
--
ALTER TABLE `information_forms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `information_forms_answers`
--
ALTER TABLE `information_forms_answers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `information_form_options`
--
ALTER TABLE `information_form_options`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `information_form_questions`
--
ALTER TABLE `information_form_questions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `innovations`
--
ALTER TABLE `innovations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `lessons`
--
ALTER TABLE `lessons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `meetings`
--
ALTER TABLE `meetings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `memberships`
--
ALTER TABLE `memberships`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `mentors`
--
ALTER TABLE `mentors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `mentor_availabilities`
--
ALTER TABLE `mentor_availabilities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT de la tabla `message_templates`
--
ALTER TABLE `message_templates`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `metodologies`
--
ALTER TABLE `metodologies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT de la tabla `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=186;

--
-- AUTO_INCREMENT de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `presential_activities`
--
ALTER TABLE `presential_activities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `presential_activities_groups`
--
ALTER TABLE `presential_activities_groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `problems`
--
ALTER TABLE `problems`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `processes`
--
ALTER TABLE `processes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `products_services`
--
ALTER TABLE `products_services`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `products_services_files`
--
ALTER TABLE `products_services_files`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `projects`
--
ALTER TABLE `projects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `proposal_templates`
--
ALTER TABLE `proposal_templates`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `proposal_templates_questions`
--
ALTER TABLE `proposal_templates_questions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `scalings`
--
ALTER TABLE `scalings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `social_engineering_answers`
--
ALTER TABLE `social_engineering_answers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `social_questions`
--
ALTER TABLE `social_questions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `solutions`
--
ALTER TABLE `solutions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `stages`
--
ALTER TABLE `stages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `steps`
--
ALTER TABLE `steps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `supports`
--
ALTER TABLE `supports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `supports_responses`
--
ALTER TABLE `supports_responses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tasks_contacts`
--
ALTER TABLE `tasks_contacts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tasks_types`
--
ALTER TABLE `tasks_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `technologies`
--
ALTER TABLE `technologies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `topics`
--
ALTER TABLE `topics`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `translations`
--
ALTER TABLE `translations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tutorials`
--
ALTER TABLE `tutorials`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `announcements_forms`
--
ALTER TABLE `announcements_forms`
  ADD CONSTRAINT `announcements_forms_announcement_id_foreign` FOREIGN KEY (`announcement_id`) REFERENCES `announcements` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `announcements_forms_commercial_form_id_foreign` FOREIGN KEY (`commercial_form_id`) REFERENCES `commercial_forms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `challenges`
--
ALTER TABLE `challenges`
  ADD CONSTRAINT `challenges_step_id_foreign` FOREIGN KEY (`step_id`) REFERENCES `steps` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `commercial_actions`
--
ALTER TABLE `commercial_actions`
  ADD CONSTRAINT `commercial_actions_commercial_strategy_foreign` FOREIGN KEY (`commercial_strategy_id`) REFERENCES `commercial_strategies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `commercial_form_options`
--
ALTER TABLE `commercial_form_options`
  ADD CONSTRAINT `commercial_form_options_commercial_form_question_foreign` FOREIGN KEY (`commercial_form_question_id`) REFERENCES `commercial_form_questions` (`id`);

--
-- Filtros para la tabla `commercial_strategies`
--
ALTER TABLE `commercial_strategies`
  ADD CONSTRAINT `commercial_strategies_ibfk_1` FOREIGN KEY (`commercial_land_id`) REFERENCES `commercial_lands` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `contacts_schedules`
--
ALTER TABLE `contacts_schedules`
  ADD CONSTRAINT `contacts_schedules_contact_id_foreign` FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_next_course_foreign` FOREIGN KEY (`next_course`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `courses_previous_course_foreign` FOREIGN KEY (`previous_course`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `data_rows`
--
ALTER TABLE `data_rows`
  ADD CONSTRAINT `data_rows_data_type_id_foreign` FOREIGN KEY (`data_type_id`) REFERENCES `data_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `information_forms`
--
ALTER TABLE `information_forms`
  ADD CONSTRAINT `information_forms_step_id_foreign` FOREIGN KEY (`step_id`) REFERENCES `steps` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `information_form_options`
--
ALTER TABLE `information_form_options`
  ADD CONSTRAINT `information_form_options_information_form_question_id_foreign` FOREIGN KEY (`information_form_question_id`) REFERENCES `information_form_questions` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `information_form_questions`
--
ALTER TABLE `information_form_questions`
  ADD CONSTRAINT `information_form_questions_information_form_id_foreign` FOREIGN KEY (`information_form_id`) REFERENCES `information_forms` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `lessons`
--
ALTER TABLE `lessons`
  ADD CONSTRAINT `lessons_topic_id_foreign` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `mentors`
--
ALTER TABLE `mentors`
  ADD CONSTRAINT `mentors_step_id_foreign` FOREIGN KEY (`step_id`) REFERENCES `steps` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `mentor_availabilities`
--
ALTER TABLE `mentor_availabilities`
  ADD CONSTRAINT `mentor_availabilities_mentor_id_foreign` FOREIGN KEY (`mentor_id`) REFERENCES `mentors` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `menu_items`
--
ALTER TABLE `menu_items`
  ADD CONSTRAINT `menu_items_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `presential_activities`
--
ALTER TABLE `presential_activities`
  ADD CONSTRAINT `presential_activities_step_id_foreign` FOREIGN KEY (`step_id`) REFERENCES `steps` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `presential_activities_groups`
--
ALTER TABLE `presential_activities_groups`
  ADD CONSTRAINT `presential_activities_groups_presential_activity_id_foreign` FOREIGN KEY (`presential_activity_id`) REFERENCES `presential_activities` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `stages`
--
ALTER TABLE `stages`
  ADD CONSTRAINT `stages_process_id_foreign` FOREIGN KEY (`process_id`) REFERENCES `processes` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `steps`
--
ALTER TABLE `steps`
  ADD CONSTRAINT `steps_stage_id_foreign` FOREIGN KEY (`stage_id`) REFERENCES `stages` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `topics`
--
ALTER TABLE `topics`
  ADD CONSTRAINT `topics_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

--
-- Filtros para la tabla `user_roles`
--
ALTER TABLE `user_roles`
  ADD CONSTRAINT `user_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_roles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
