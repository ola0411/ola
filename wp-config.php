<?php
/**
 * Основные параметры WordPress.
 *
 * Этот файл содержит следующие параметры: настройки MySQL, префикс таблиц,
 * секретные ключи и ABSPATH. Дополнительную информацию можно найти на странице
 * {@link http://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Кодекса. Настройки MySQL можно узнать у хостинг-провайдера.
 *
 * Этот файл используется скриптом для создания wp-config.php в процессе установки.
 * Необязательно использовать веб-интерфейс, можно скопировать этот файл
 * с именем "wp-config.php" и заполнить значения вручную.
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define('DB_NAME', 'movie_2015');

/** Имя пользователя MySQL */
define('DB_USER', 'root');

/** Пароль к базе данных MySQL */
define('DB_PASSWORD', '123');

/** Имя сервера MySQL */
define('DB_HOST', 'localhost');

/** Кодировка базы данных для создания таблиц. */
define('DB_CHARSET', 'utf8');

/** Схема сопоставления. Не меняйте, если не уверены. */
define('DB_COLLATE', '');

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'HrrLZ!|us_53@}5zno2HZM)h:7G2TL2DQ.)+q6|MN/S)5CLZR!.RBE|F*%ju/k5|');
define('SECURE_AUTH_KEY',  '8F[G.&QQ>tM+_K$g(8QZ$A|>9FaRvH-GVC:`@K0.wcJ3C+qc}8jV&hrt#.Etag-n');
define('LOGGED_IN_KEY',    'N67U!GL69z9{m^(n~i,qO.loRvcZl|Di7tF7[1gF-x>OkGH=1&fz^ebNAS~q)e]|');
define('NONCE_KEY',        '}fQp^^!Cf(A.ilV~[Q5X|Iyig@h8R`]E1a)9_E.IHE9Q[@O.l([8.Yq14EFK(nHZ');
define('AUTH_SALT',        'pj<Kqg7=kqIv:Y/:>T-=*UZgX_~Y7F2en iDp+! pcf8UUjt^gt[/nAzM:Sif>:e');
define('SECURE_AUTH_SALT', ':o.=N<dv|;}4L%7g24@FqlJ[nAiSg+GHgH{h~{S+`eJWnej?h)G|`T-<aKrH[{3F');
define('LOGGED_IN_SALT',   'YO[p|qM&y*RLc:>qtVD}{Zz;@He1h =W41`|0T]TGzc6d8n2i}1W=[IVhpRz5S&U');
define('NONCE_SALT',       ';P-<W|n42[^&Q)`)u =>sjt(`LIUEjNOJ.iev?p `310HmBOXiN-rej-e+ 81Sny');

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix  = 'wp_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 */
define('WP_DEBUG', false);

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Инициализирует переменные WordPress и подключает файлы. */
require_once(ABSPATH . 'wp-settings.php');
