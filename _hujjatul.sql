/*
 Navicat Premium Dump SQL

 Source Server         : local
 Source Server Type    : MySQL
 Source Server Version : 80043 (8.0.43)
 Source Host           : localhost:3306
 Source Schema         : _hujjatul

 Target Server Type    : MySQL
 Target Server Version : 80043 (8.0.43)
 File Encoding         : 65001

 Date: 13/04/2026 14:10:29
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for cache
-- ----------------------------
DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of cache
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for cache_locks
-- ----------------------------
DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of cache_locks
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for job_batches
-- ----------------------------
DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of job_batches
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for jobs
-- ----------------------------
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of jobs
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for layanans
-- ----------------------------
DROP TABLE IF EXISTS `layanans`;
CREATE TABLE `layanans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `layanans_nama_index` (`nama`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of layanans
-- ----------------------------
BEGIN;
INSERT INTO `layanans` (`id`, `nama`, `deskripsi`, `is_active`, `created_at`, `updated_at`) VALUES (1, 'Surat Domisili', 'Surat Domisili', 1, '2026-03-08 07:47:57', '2026-03-08 07:47:57');
COMMIT;

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------
BEGIN;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (1, '0001_01_01_000000_create_users_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (2, '0001_01_01_000001_create_cache_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (3, '0001_01_01_000002_create_jobs_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (4, '2026_03_08_064646_create_penduduks_table', 2);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (6, '2026_03_08_071534_alter_jenis_kelamin_column_in_penduduks_table', 3);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (7, '2026_03_08_072750_create_layanans_table', 4);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (8, '2026_03_08_072806_create_persyaratan_table', 4);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (9, '2026_03_08_160000_create_pengajuans_table', 5);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (10, '2026_03_08_160100_create_pengajuan_status_histories_table', 5);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (11, '2026_03_08_084042_create_pengajuan_dokumen_table', 6);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (12, '2026_03_08_091058_create_profil_desas_table', 7);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (13, '2026_03_08_091805_create_surats_table', 8);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (14, '2026_03_08_092318_add_jenis_surat_to_surats_table', 9);
COMMIT;

-- ----------------------------
-- Table structure for password_reset_tokens
-- ----------------------------
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of password_reset_tokens
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for penduduks
-- ----------------------------
DROP TABLE IF EXISTS `penduduks`;
CREATE TABLE `penduduks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nik` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_lengkap` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tempat_lahir` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `desa` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `agama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_kawin` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pekerjaan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_hp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `penduduks_nik_unique` (`nik`),
  KEY `penduduks_nik_index` (`nik`),
  KEY `penduduks_nama_lengkap_index` (`nama_lengkap`),
  KEY `penduduks_user_id_index` (`user_id`),
  CONSTRAINT `penduduks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of penduduks
-- ----------------------------
BEGIN;
INSERT INTO `penduduks` (`id`, `nik`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `desa`, `agama`, `status_kawin`, `pekerjaan`, `no_hp`, `user_id`, `created_at`, `updated_at`) VALUES (2, '3245432145463224', 'asrani', 'banjarmasin', '1990-03-15', 'Laki-laki', 'sdf', 'Desa Kersik Putih ', 'Islam', 'Belum Menikah', 'asd', '0987654', NULL, '2026-03-08 07:18:21', '2026-03-08 07:24:26');
INSERT INTO `penduduks` (`id`, `nik`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `desa`, `agama`, `status_kawin`, `pekerjaan`, `no_hp`, `user_id`, `created_at`, `updated_at`) VALUES (3, '5866686201217989', 'Mrs. Ethyl Murphy', 'West Elton', '1981-09-26', 'Perempuan', '320 Abshire Ramp Suite 844\nBauchborough, AK 20518-2612', 'Desa Kersik Putih ', 'Kristen', 'Cerai Mati', 'Nelayan', '1-425-832-6672', NULL, '2026-03-08 07:26:27', '2026-03-08 07:26:27');
INSERT INTO `penduduks` (`id`, `nik`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `desa`, `agama`, `status_kawin`, `pekerjaan`, `no_hp`, `user_id`, `created_at`, `updated_at`) VALUES (4, '0976834609094275', 'Vernon Keeling', 'North Joesphhaven', '2011-11-01', 'Laki-laki', '264 Macejkovic Lights Apt. 561\nSchimmelburgh, NY 89648', 'Desa Kersik Putih ', 'Katolik', 'Cerai Hidup', 'Nelayan', '+1.307.942.9945', NULL, '2026-03-08 07:26:27', '2026-03-08 07:26:27');
INSERT INTO `penduduks` (`id`, `nik`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `desa`, `agama`, `status_kawin`, `pekerjaan`, `no_hp`, `user_id`, `created_at`, `updated_at`) VALUES (5, '9300693254614349', 'Miss Cali Bode', 'Lake Roytown', '1974-10-21', 'Laki-laki', '9226 Bashirian Forks Suite 321\nNorth Alexanne, NM 94059', 'Desa Kersik Putih ', 'Islam', 'Menikah', 'Wiraswasta', '818-924-7978', NULL, '2026-03-08 07:26:27', '2026-03-08 07:26:27');
INSERT INTO `penduduks` (`id`, `nik`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `desa`, `agama`, `status_kawin`, `pekerjaan`, `no_hp`, `user_id`, `created_at`, `updated_at`) VALUES (6, '3416670685306357', 'Miss Lempi Bailey', 'Carmelfurt', '2001-04-19', 'Perempuan', '602 Bernadette Lakes Apt. 467\nAngelicaside, NM 58419', 'Desa Kersik Putih ', 'Islam', 'Cerai Hidup', 'Guru', '+1.601.462.9863', NULL, '2026-03-08 07:26:27', '2026-03-08 07:26:27');
INSERT INTO `penduduks` (`id`, `nik`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `desa`, `agama`, `status_kawin`, `pekerjaan`, `no_hp`, `user_id`, `created_at`, `updated_at`) VALUES (7, '1627605434979217', 'Marcelina Parker', 'Schmittmouth', '1976-10-03', 'Laki-laki', '67556 Peyton Isle Suite 912\nPort Danview, TN 20845', 'Desa Kersik Putih ', 'Islam', 'Cerai Hidup', 'Petani', '1-223-974-0500', NULL, '2026-03-08 07:26:27', '2026-03-08 07:26:27');
INSERT INTO `penduduks` (`id`, `nik`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `desa`, `agama`, `status_kawin`, `pekerjaan`, `no_hp`, `user_id`, `created_at`, `updated_at`) VALUES (8, '0848374719757421', 'Prof. Cecilia Conroy DDS', 'Stoltenbergchester', '1988-03-15', 'Laki-laki', '35868 Jarvis Corner\nLake Luz, CO 95403', 'Desa Kersik Putih ', 'Hindu', 'Belum Menikah', 'Mahasiswa', '559.223.1577', NULL, '2026-03-08 07:26:27', '2026-03-08 07:26:27');
INSERT INTO `penduduks` (`id`, `nik`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `desa`, `agama`, `status_kawin`, `pekerjaan`, `no_hp`, `user_id`, `created_at`, `updated_at`) VALUES (9, '7213616916547840', 'Lawson Koepp Jr.', 'Isomborough', '1971-04-09', 'Perempuan', '6322 Herzog Stravenue\nPort Justice, GA 37214-3011', 'Desa Kersik Putih ', 'Buddha', 'Cerai Hidup', 'Wiraswasta', '269-652-9418', NULL, '2026-03-08 07:26:27', '2026-03-08 07:26:27');
INSERT INTO `penduduks` (`id`, `nik`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `desa`, `agama`, `status_kawin`, `pekerjaan`, `no_hp`, `user_id`, `created_at`, `updated_at`) VALUES (10, '6862401477856536', 'Earl Ankunding', 'North Zander', '2021-08-04', 'Laki-laki', '7645 Sonia Creek Suite 396\nFriesenborough, MN 53051', 'Desa Kersik Putih ', 'Buddha', 'Menikah', 'Nelayan', '831.356.5399', NULL, '2026-03-08 07:26:27', '2026-03-08 07:26:27');
INSERT INTO `penduduks` (`id`, `nik`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `desa`, `agama`, `status_kawin`, `pekerjaan`, `no_hp`, `user_id`, `created_at`, `updated_at`) VALUES (11, '5469566104178818', 'Ms. Name Gorczany Sr.', 'Jacobshaven', '1970-07-31', 'Laki-laki', '60089 O\'Kon Walk\nPort Andersontown, NJ 38686-9858', 'Desa Kersik Putih ', 'Hindu', 'Cerai Hidup', 'PNS', '+19105595175', NULL, '2026-03-08 07:26:27', '2026-03-08 07:26:27');
INSERT INTO `penduduks` (`id`, `nik`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `desa`, `agama`, `status_kawin`, `pekerjaan`, `no_hp`, `user_id`, `created_at`, `updated_at`) VALUES (12, '8792466962589914', 'Rey Krajcik', 'Port Keithmouth', '1993-06-26', 'Perempuan', '13582 Tremayne Landing Apt. 441\nEstebanview, CT 02350-7849', 'Desa Kersik Putih ', 'Konghucu', 'Cerai Hidup', 'Mahasiswa', '1-775-907-8859', NULL, '2026-03-08 07:26:27', '2026-03-08 07:26:27');
INSERT INTO `penduduks` (`id`, `nik`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `desa`, `agama`, `status_kawin`, `pekerjaan`, `no_hp`, `user_id`, `created_at`, `updated_at`) VALUES (13, '5390127297639496', 'Mallory Hayes DVM', 'Kaiaton', '1983-08-10', 'Perempuan', '63324 Wiza Squares Suite 871\nNorth Mohammedview, MS 19124', 'Desa Kersik Putih ', 'Islam', 'Menikah', 'Mahasiswa', '(605) 810-1131', NULL, '2026-03-08 07:26:27', '2026-03-08 07:26:27');
INSERT INTO `penduduks` (`id`, `nik`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `desa`, `agama`, `status_kawin`, `pekerjaan`, `no_hp`, `user_id`, `created_at`, `updated_at`) VALUES (14, '2945300998085958', 'Dr. Immanuel Runolfsdottir', 'Jalynchester', '1985-04-07', 'Laki-laki', '65959 Elyse Extension\nSouth Elissa, GA 73326-0381', 'Desa Kersik Putih ', 'Islam', 'Belum Menikah', 'Nelayan', '1-682-461-2948', NULL, '2026-03-08 07:26:27', '2026-03-08 07:26:27');
INSERT INTO `penduduks` (`id`, `nik`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `desa`, `agama`, `status_kawin`, `pekerjaan`, `no_hp`, `user_id`, `created_at`, `updated_at`) VALUES (15, '3241921058043037', 'Issac Nicolas', 'Kassulkeborough', '1974-03-03', 'Perempuan', '5869 Padberg Streets Suite 548\nPort Roscoe, AZ 39121', 'Desa Kersik Putih ', 'Konghucu', 'Cerai Hidup', 'Buruh', '+1 (725) 406-5746', NULL, '2026-03-08 07:26:27', '2026-03-08 07:26:27');
INSERT INTO `penduduks` (`id`, `nik`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `desa`, `agama`, `status_kawin`, `pekerjaan`, `no_hp`, `user_id`, `created_at`, `updated_at`) VALUES (16, '7181038797055057', 'Mr. Jerel Schmeler', 'East Grayceborough', '1979-02-10', 'Laki-laki', '203 Kihn Port Suite 414\nSouth Alice, MD 70301', 'Desa Kersik Putih ', 'Kristen', 'Cerai Mati', 'Mahasiswa', '+1-281-709-4593', NULL, '2026-03-08 07:26:27', '2026-03-08 07:26:27');
INSERT INTO `penduduks` (`id`, `nik`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `desa`, `agama`, `status_kawin`, `pekerjaan`, `no_hp`, `user_id`, `created_at`, `updated_at`) VALUES (17, '3160468471814349', 'Mrs. Rebeka Bergnaum', 'New Orlostad', '2021-12-23', 'Laki-laki', '716 Muller Orchard Suite 460\nEast Kiannafort, VT 42009-9854', 'Desa Kersik Putih ', 'Konghucu', 'Cerai Mati', 'Buruh', '1-404-260-3257', NULL, '2026-03-08 07:26:27', '2026-03-08 07:26:27');
INSERT INTO `penduduks` (`id`, `nik`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `desa`, `agama`, `status_kawin`, `pekerjaan`, `no_hp`, `user_id`, `created_at`, `updated_at`) VALUES (18, '7888384524421142', 'Cleora Gaylord', 'Metzmouth', '2023-12-19', 'Perempuan', '383 Javonte Island\nFreedaland, TX 57608-9160', 'Desa Kersik Putih ', 'Katolik', 'Menikah', 'Buruh', '646-626-3958', NULL, '2026-03-08 07:26:27', '2026-03-08 07:26:27');
INSERT INTO `penduduks` (`id`, `nik`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `desa`, `agama`, `status_kawin`, `pekerjaan`, `no_hp`, `user_id`, `created_at`, `updated_at`) VALUES (19, '4847931612536968', 'Landen Glover', 'New Tracymouth', '2017-11-17', 'Perempuan', '84553 Orn Forge\nWest Gunnar, VA 04450', 'Desa Kersik Putih ', 'Konghucu', 'Cerai Mati', 'Wiraswasta', '+1-540-873-4317', NULL, '2026-03-08 07:26:27', '2026-03-08 07:26:27');
INSERT INTO `penduduks` (`id`, `nik`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `desa`, `agama`, `status_kawin`, `pekerjaan`, `no_hp`, `user_id`, `created_at`, `updated_at`) VALUES (20, '8603291516462665', 'Marcelina Runolfsson', 'Beerfort', '1980-04-06', 'Laki-laki', '990 Charley Rue Apt. 913\nLake Antonehaven, NV 75727-1129', 'Desa Kersik Putih ', 'Islam', 'Cerai Hidup', 'Petani', '1-507-571-4316', NULL, '2026-03-08 07:26:27', '2026-03-08 07:26:27');
INSERT INTO `penduduks` (`id`, `nik`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `desa`, `agama`, `status_kawin`, `pekerjaan`, `no_hp`, `user_id`, `created_at`, `updated_at`) VALUES (21, '5012940085275693', 'Lora Buckridge', 'East Trystan', '1989-09-03', 'Perempuan', '568 Toney Views Apt. 038\nNorth Heloise, RI 48708', 'Desa Kersik Putih ', 'Buddha', 'Belum Menikah', 'Mahasiswa', '1-302-921-6079', NULL, '2026-03-08 07:26:27', '2026-03-08 07:26:27');
INSERT INTO `penduduks` (`id`, `nik`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `desa`, `agama`, `status_kawin`, `pekerjaan`, `no_hp`, `user_id`, `created_at`, `updated_at`) VALUES (22, '2188584737495324', 'Violette Hoppe MD', 'Port Carlochester', '1970-12-14', 'Laki-laki', '358 Michelle Via\nNorth Dwightbury, KS 05302-0498', 'Desa Kersik Putih ', 'Kristen', 'Cerai Mati', 'Petani', '314.975.1694', NULL, '2026-03-08 07:26:27', '2026-03-08 07:26:27');
INSERT INTO `penduduks` (`id`, `nik`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `desa`, `agama`, `status_kawin`, `pekerjaan`, `no_hp`, `user_id`, `created_at`, `updated_at`) VALUES (23, '6462415171843787', 'Ms. Adelle Bahringer', 'Port Gilda', '1978-10-01', 'Laki-laki', '402 Jayson Road Suite 997\nSouth Krystinabury, NM 84395-9765', 'Desa Kersik Putih ', 'Katolik', 'Cerai Mati', 'Guru', '(828) 557-4603', NULL, '2026-03-08 07:26:27', '2026-03-08 07:26:27');
INSERT INTO `penduduks` (`id`, `nik`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `desa`, `agama`, `status_kawin`, `pekerjaan`, `no_hp`, `user_id`, `created_at`, `updated_at`) VALUES (24, '8715641791899937', 'Joelle Bahringer', 'Hayestown', '1979-11-26', 'Perempuan', '919 Schmeler Gateway\nGrantland, NY 01346', 'Desa Kersik Putih ', 'Buddha', 'Cerai Mati', 'Guru', '(252) 752-6525', NULL, '2026-03-08 07:26:27', '2026-03-08 07:26:27');
INSERT INTO `penduduks` (`id`, `nik`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `desa`, `agama`, `status_kawin`, `pekerjaan`, `no_hp`, `user_id`, `created_at`, `updated_at`) VALUES (25, '9714768575791386', 'Jesus Ondricka', 'Timothyburgh', '2004-06-04', 'Perempuan', '3496 Beahan Expressway\nLake Ashlyfort, ID 32142-0957', 'Desa Kersik Putih ', 'Hindu', 'Cerai Mati', 'Ibu Rumah Tangga', '763.279.7920', NULL, '2026-03-08 07:26:27', '2026-03-08 07:26:27');
INSERT INTO `penduduks` (`id`, `nik`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `desa`, `agama`, `status_kawin`, `pekerjaan`, `no_hp`, `user_id`, `created_at`, `updated_at`) VALUES (26, '0872949337474477', 'Leonardo Stokes', 'South Marielleside', '1981-08-25', 'Laki-laki', '3861 Jenkins Ridges Apt. 096\nLake Marilynefurt, VT 09581-7840', 'Desa Kersik Putih ', 'Kristen', 'Cerai Hidup', 'Nelayan', '(661) 293-1890', NULL, '2026-03-08 07:26:27', '2026-03-08 07:26:27');
INSERT INTO `penduduks` (`id`, `nik`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `desa`, `agama`, `status_kawin`, `pekerjaan`, `no_hp`, `user_id`, `created_at`, `updated_at`) VALUES (27, '1523655331966789', 'Dr. Demario Frami', 'Port Carmenland', '1974-07-31', 'Perempuan', '2252 Geovanny Lights\nNorth Lourdeston, IA 56103', 'Desa Kersik Putih ', 'Buddha', 'Menikah', 'Petani', '+1-859-253-9980', NULL, '2026-03-08 07:26:27', '2026-03-08 07:26:27');
INSERT INTO `penduduks` (`id`, `nik`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `desa`, `agama`, `status_kawin`, `pekerjaan`, `no_hp`, `user_id`, `created_at`, `updated_at`) VALUES (28, '9730384537547701', 'Amira McGlynn', 'Lake Esta', '2005-06-26', 'Perempuan', '9596 Ramona Trace Apt. 767\nAbbieton, IN 89217', 'Desa Kersik Putih ', 'Konghucu', 'Cerai Hidup', 'Nelayan', '+13232655761', NULL, '2026-03-08 07:26:27', '2026-03-08 07:26:27');
INSERT INTO `penduduks` (`id`, `nik`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `desa`, `agama`, `status_kawin`, `pekerjaan`, `no_hp`, `user_id`, `created_at`, `updated_at`) VALUES (29, '2615756265815660', 'Prof. Ladarius Pfannerstill MD', 'South Mabel', '1996-11-12', 'Laki-laki', '96247 Thompson Flats Apt. 642\nPfannerstillbury, KS 71310-9874', 'Desa Kersik Putih ', 'Kristen', 'Belum Menikah', 'Ibu Rumah Tangga', '469-229-1430', NULL, '2026-03-08 07:26:27', '2026-03-08 07:26:27');
INSERT INTO `penduduks` (`id`, `nik`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `desa`, `agama`, `status_kawin`, `pekerjaan`, `no_hp`, `user_id`, `created_at`, `updated_at`) VALUES (30, '4132781512283879', 'Dr. Scottie Conroy IV', 'Stokesshire', '2001-07-28', 'Laki-laki', '478 Alaina River\nSchinnermouth, AR 44128', 'Desa Kersik Putih ', 'Konghucu', 'Belum Menikah', 'Buruh', '502.922.9604', NULL, '2026-03-08 07:26:27', '2026-03-08 07:26:27');
INSERT INTO `penduduks` (`id`, `nik`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `desa`, `agama`, `status_kawin`, `pekerjaan`, `no_hp`, `user_id`, `created_at`, `updated_at`) VALUES (31, '8623010262903299', 'Braeden Jaskolski', 'East Duaneville', '1999-12-30', 'Laki-laki', '81357 Carolina Heights Suite 931\nPort Jadeton, ID 27049-2346', 'Desa Kersik Putih ', 'Kristen', 'Cerai Mati', 'Petani', '910.209.0825', NULL, '2026-03-08 07:26:27', '2026-03-08 07:26:27');
INSERT INTO `penduduks` (`id`, `nik`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `desa`, `agama`, `status_kawin`, `pekerjaan`, `no_hp`, `user_id`, `created_at`, `updated_at`) VALUES (32, '0176878642321667', 'Jessyca O\'Kon', 'Port Reyton', '1988-04-18', 'Perempuan', '853 Nienow Centers Suite 578\nPort Casandraport, KY 07702-4036', 'Desa Kersik Putih ', 'Kristen', 'Cerai Hidup', 'Wiraswasta', '+1-307-215-8648', NULL, '2026-03-08 07:26:27', '2026-03-08 07:26:27');
INSERT INTO `penduduks` (`id`, `nik`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `desa`, `agama`, `status_kawin`, `pekerjaan`, `no_hp`, `user_id`, `created_at`, `updated_at`) VALUES (33, '4596326900383293', 'Jany Stanton', 'Lake Uliseshaven', '2022-12-19', 'Perempuan', '8597 Auer Oval\nSwaniawskifurt, TX 96186-3804', 'Desa Kersik Putih ', 'Buddha', 'Belum Menikah', 'Mahasiswa', '256.360.9727', NULL, '2026-03-08 07:26:27', '2026-03-08 07:26:27');
INSERT INTO `penduduks` (`id`, `nik`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `desa`, `agama`, `status_kawin`, `pekerjaan`, `no_hp`, `user_id`, `created_at`, `updated_at`) VALUES (34, '8296682507597868', 'Prof. Lowell Reichel', 'New Allen', '1982-04-26', 'Laki-laki', '8956 Susanna Radial Apt. 493\nPort Reinholdhaven, NC 88961', 'Desa Kersik Putih ', 'Hindu', 'Belum Menikah', 'Mahasiswa', '(830) 321-3481', NULL, '2026-03-08 07:26:27', '2026-03-08 07:26:27');
INSERT INTO `penduduks` (`id`, `nik`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `desa`, `agama`, `status_kawin`, `pekerjaan`, `no_hp`, `user_id`, `created_at`, `updated_at`) VALUES (35, '3832343695838394', 'Mrs. Cordie Dietrich PhD', 'East Sheila', '1990-05-26', 'Laki-laki', '78689 Morton Freeway\nErnestinaburgh, OH 04049', 'Desa Kersik Putih ', 'Konghucu', 'Cerai Mati', 'Petani', '(475) 371-8343', NULL, '2026-03-08 07:26:27', '2026-03-08 07:26:27');
INSERT INTO `penduduks` (`id`, `nik`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `desa`, `agama`, `status_kawin`, `pekerjaan`, `no_hp`, `user_id`, `created_at`, `updated_at`) VALUES (36, '4003831602484551', 'Jeromy Christiansen III', 'Krajcikhaven', '2020-06-12', 'Laki-laki', '236 Quigley Light Apt. 523\nAlvisshire, WV 15177', 'Desa Kersik Putih ', 'Hindu', 'Cerai Mati', 'Mahasiswa', '541-637-6628', NULL, '2026-03-08 07:26:27', '2026-03-08 07:26:27');
INSERT INTO `penduduks` (`id`, `nik`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `desa`, `agama`, `status_kawin`, `pekerjaan`, `no_hp`, `user_id`, `created_at`, `updated_at`) VALUES (37, '5165563075544329', 'Roselyn Rice', 'Caseyville', '2017-09-02', 'Perempuan', '969 Anibal Place Apt. 266\nDaughertyburgh, WA 98409', 'Desa Kersik Putih ', 'Konghucu', 'Cerai Hidup', 'Guru', '351-303-2757', NULL, '2026-03-08 07:26:27', '2026-03-08 07:26:27');
INSERT INTO `penduduks` (`id`, `nik`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `desa`, `agama`, `status_kawin`, `pekerjaan`, `no_hp`, `user_id`, `created_at`, `updated_at`) VALUES (38, '5558866111702261', 'Velma Will', 'Ullrichfort', '1995-07-14', 'Perempuan', '36562 Amy Dale Apt. 082\nLaurettabury, MD 26987-5435', 'Desa Kersik Putih ', 'Buddha', 'Belum Menikah', 'Mahasiswa', '321-449-6126', NULL, '2026-03-08 07:26:27', '2026-03-08 07:26:27');
INSERT INTO `penduduks` (`id`, `nik`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `desa`, `agama`, `status_kawin`, `pekerjaan`, `no_hp`, `user_id`, `created_at`, `updated_at`) VALUES (39, '7500154058559700', 'Margot Sauer', 'Lake Norma', '1993-08-08', 'Laki-laki', '99806 Eliza Green\nNew Icie, NY 24987-5225', 'Desa Kersik Putih ', 'Konghucu', 'Belum Menikah', 'PNS', '803-933-8501', NULL, '2026-03-08 07:26:27', '2026-03-08 07:26:27');
INSERT INTO `penduduks` (`id`, `nik`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `desa`, `agama`, `status_kawin`, `pekerjaan`, `no_hp`, `user_id`, `created_at`, `updated_at`) VALUES (40, '6388983599505709', 'Noemy Schimmel', 'Ashleeshire', '2013-10-19', 'Laki-laki', '547 Brekke Lakes\nWest Ida, TX 45202', 'Desa Kersik Putih ', 'Kristen', 'Menikah', 'Wiraswasta', '1-980-562-1617', NULL, '2026-03-08 07:26:27', '2026-03-08 07:26:27');
INSERT INTO `penduduks` (`id`, `nik`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `desa`, `agama`, `status_kawin`, `pekerjaan`, `no_hp`, `user_id`, `created_at`, `updated_at`) VALUES (41, '8023142083203613', 'Deonte Lesch', 'Gerlachview', '2010-11-20', 'Perempuan', '815 Vincenza Groves Apt. 622\nWest Rafael, MO 77213', 'Desa Kersik Putih ', 'Katolik', 'Cerai Mati', 'PNS', '463.535.3627', NULL, '2026-03-08 07:26:27', '2026-03-08 07:26:27');
INSERT INTO `penduduks` (`id`, `nik`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `desa`, `agama`, `status_kawin`, `pekerjaan`, `no_hp`, `user_id`, `created_at`, `updated_at`) VALUES (42, '9098364602240987', 'Mrs. Estrella Renner', 'Murazikside', '1982-09-06', 'Perempuan', '15861 Wyman Crescent\nRatkemouth, AL 91648-9650', 'Desa Kersik Putih ', 'Buddha', 'Cerai Hidup', 'Wiraswasta', '857-920-5251', NULL, '2026-03-08 07:26:27', '2026-03-08 07:26:27');
INSERT INTO `penduduks` (`id`, `nik`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `desa`, `agama`, `status_kawin`, `pekerjaan`, `no_hp`, `user_id`, `created_at`, `updated_at`) VALUES (43, '7471637658893422', 'Dr. William Littel', 'Edwinport', '2012-01-18', 'Laki-laki', '8918 Glover Islands\nDinamouth, CO 11504-7018', 'Desa Kersik Putih ', 'Hindu', 'Cerai Mati', 'Petani', '+1 (847) 983-2139', NULL, '2026-03-08 07:26:27', '2026-03-08 07:26:27');
INSERT INTO `penduduks` (`id`, `nik`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `desa`, `agama`, `status_kawin`, `pekerjaan`, `no_hp`, `user_id`, `created_at`, `updated_at`) VALUES (44, '5581106337836527', 'Dr. Jerel Hauck', 'New Tyson', '2014-02-05', 'Laki-laki', '40633 Yasmin Rapid\nWest Zack, MN 10988-7127', 'Desa Kersik Putih ', 'Buddha', 'Belum Menikah', 'Nelayan', '(503) 359-9694', NULL, '2026-03-08 07:26:27', '2026-03-08 07:26:27');
INSERT INTO `penduduks` (`id`, `nik`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `desa`, `agama`, `status_kawin`, `pekerjaan`, `no_hp`, `user_id`, `created_at`, `updated_at`) VALUES (45, '8760636726432402', 'Mrs. Nella Schmeler', 'Manteberg', '1986-12-16', 'Perempuan', '3554 Sienna Mall Apt. 946\nStokesville, WV 68454-6537', 'Desa Kersik Putih ', 'Hindu', 'Cerai Mati', 'Mahasiswa', '1-272-869-7533', NULL, '2026-03-08 07:26:27', '2026-03-08 07:26:27');
INSERT INTO `penduduks` (`id`, `nik`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `desa`, `agama`, `status_kawin`, `pekerjaan`, `no_hp`, `user_id`, `created_at`, `updated_at`) VALUES (46, '6253124441926580', 'Carolyn Bahringer Jr.', 'Kirlinville', '1988-04-13', 'Perempuan', '4801 Charlotte Junction\nNorth Rasheed, CO 56531-0491', 'Desa Kersik Putih ', 'Buddha', 'Belum Menikah', 'Buruh', '+1.220.556.8718', NULL, '2026-03-08 07:26:27', '2026-03-08 07:26:27');
INSERT INTO `penduduks` (`id`, `nik`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `desa`, `agama`, `status_kawin`, `pekerjaan`, `no_hp`, `user_id`, `created_at`, `updated_at`) VALUES (47, '3270200715723855', 'Agustina Robel Jr.', 'Bartellside', '1974-07-31', 'Laki-laki', '89939 Laverne Springs Suite 274\nEast Gerardo, CA 86751-4511', 'Desa Kersik Putih ', 'Islam', 'Cerai Mati', 'Mahasiswa', '+1 (351) 871-0129', NULL, '2026-03-08 07:26:27', '2026-03-08 07:26:27');
INSERT INTO `penduduks` (`id`, `nik`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `desa`, `agama`, `status_kawin`, `pekerjaan`, `no_hp`, `user_id`, `created_at`, `updated_at`) VALUES (48, '2893839984809477', 'Shanny Glover', 'Emmerichhaven', '2016-07-17', 'Laki-laki', '2236 Dickens Mill\nNew Wilmahaven, HI 43830', 'Desa Kersik Putih ', 'Konghucu', 'Belum Menikah', 'Ibu Rumah Tangga', '1-484-342-0786', NULL, '2026-03-08 07:26:27', '2026-03-08 07:26:27');
INSERT INTO `penduduks` (`id`, `nik`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `desa`, `agama`, `status_kawin`, `pekerjaan`, `no_hp`, `user_id`, `created_at`, `updated_at`) VALUES (49, '9734360839248480', 'Ardith Murazik', 'New Lelandbury', '2015-07-23', 'Laki-laki', '9412 Belle Squares Suite 088\nEmilshire, WI 59097', 'Desa Kersik Putih ', 'Katolik', 'Menikah', 'Wiraswasta', '585-312-8432', NULL, '2026-03-08 07:26:27', '2026-03-08 07:26:27');
INSERT INTO `penduduks` (`id`, `nik`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `desa`, `agama`, `status_kawin`, `pekerjaan`, `no_hp`, `user_id`, `created_at`, `updated_at`) VALUES (50, '6800513035161637', 'Mercedes Connelly', 'Altenwerthland', '1984-02-20', 'Perempuan', '79109 Torp Alley Apt. 451\nEast Saulborough, FL 58810-9620', 'Desa Kersik Putih ', 'Buddha', 'Cerai Hidup', 'Wiraswasta', '+1.463.816.9535', NULL, '2026-03-08 07:26:27', '2026-03-08 07:26:27');
INSERT INTO `penduduks` (`id`, `nik`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `desa`, `agama`, `status_kawin`, `pekerjaan`, `no_hp`, `user_id`, `created_at`, `updated_at`) VALUES (51, '2100372888935021', 'Mrs. Clara Bauch', 'Nicolasmouth', '2015-11-04', 'Perempuan', '9697 Cyril Estate\nWest Erica, SC 67117', 'Desa Kersik Putih ', 'Hindu', 'Cerai Hidup', 'Buruh', '1-539-321-5238', NULL, '2026-03-08 07:26:27', '2026-03-08 07:26:27');
INSERT INTO `penduduks` (`id`, `nik`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `desa`, `agama`, `status_kawin`, `pekerjaan`, `no_hp`, `user_id`, `created_at`, `updated_at`) VALUES (52, '3258812048960008', 'Edwardo Abshire', 'Cedrickfurt', '1999-01-18', 'Perempuan', '3367 Jacobs Grove Suite 375\nPort Cliftonfort, MS 02131-4838', 'Desa Kersik Putih ', 'Hindu', 'Belum Menikah', 'Nelayan', '+15392107389', NULL, '2026-03-08 07:26:27', '2026-03-08 07:26:27');
INSERT INTO `penduduks` (`id`, `nik`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `desa`, `agama`, `status_kawin`, `pekerjaan`, `no_hp`, `user_id`, `created_at`, `updated_at`) VALUES (53, '4353543214565432', 'fds', 'sdf', '2026-03-08', 'Laki-laki', 'sdf', 'sdf', 'Islam', 'Menikah', 'sdf', 'sdf', NULL, '2026-03-08 10:04:17', '2026-03-08 10:04:17');
INSERT INTO `penduduks` (`id`, `nik`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `desa`, `agama`, `status_kawin`, `pekerjaan`, `no_hp`, `user_id`, `created_at`, `updated_at`) VALUES (54, '5647543245654326', 'sad', 'sdfsdf', '2026-03-08', 'Laki-laki', 'sdfsdf', 'sdfsdf', 'Islam', 'Belum Menikah', 'sdfdsfsdf', 'sdfsdf', 6, '2026-03-08 10:05:11', '2026-03-08 11:47:57');
INSERT INTO `penduduks` (`id`, `nik`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `desa`, `agama`, `status_kawin`, `pekerjaan`, `no_hp`, `user_id`, `created_at`, `updated_at`) VALUES (55, '2332454324534242', 'andi', 'sdf', '2026-03-01', 'Laki-laki', 'sf', 'Desa Kersik Putih', 'Islam', 'Belum Menikah', 'dsf', 'df', 7, '2026-03-08 12:02:06', '2026-03-08 12:02:06');
INSERT INTO `penduduks` (`id`, `nik`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `desa`, `agama`, `status_kawin`, `pekerjaan`, `no_hp`, `user_id`, `created_at`, `updated_at`) VALUES (56, '6371030807720012', 'Asrani no last name', 'df', '2026-03-08', 'Laki-laki', 'Jl Pramuka Km 6 Gg Teratai', 'Desa Kersik Putih', 'Islam', 'Belum Menikah', 'dsf', '087870921486', 8, '2026-03-08 12:05:49', '2026-03-08 12:05:50');
COMMIT;

-- ----------------------------
-- Table structure for pengajuan_dokumen
-- ----------------------------
DROP TABLE IF EXISTS `pengajuan_dokumen`;
CREATE TABLE `pengajuan_dokumen` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `pengajuan_id` bigint unsigned NOT NULL,
  `persyaratan_id` bigint unsigned NOT NULL,
  `nama_file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `path_file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ukuran_file` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pengajuan_dokumen_pengajuan_id_foreign` (`pengajuan_id`),
  KEY `pengajuan_dokumen_persyaratan_id_foreign` (`persyaratan_id`),
  CONSTRAINT `pengajuan_dokumen_pengajuan_id_foreign` FOREIGN KEY (`pengajuan_id`) REFERENCES `pengajuans` (`id`) ON DELETE CASCADE,
  CONSTRAINT `pengajuan_dokumen_persyaratan_id_foreign` FOREIGN KEY (`persyaratan_id`) REFERENCES `persyaratans` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of pengajuan_dokumen
-- ----------------------------
BEGIN;
INSERT INTO `pengajuan_dokumen` (`id`, `pengajuan_id`, `persyaratan_id`, `nama_file`, `path_file`, `mime_type`, `ukuran_file`, `created_at`, `updated_at`) VALUES (1, 4, 1, 'Screenshot 2026-03-06 at 15.14.47.png', 'pengajuan/4/SCZXvZ6YKUoVhoofKvygeoOvrxJq4FDUaAzRgAbq.png', 'image/png', 93450, '2026-03-08 09:03:51', '2026-03-08 09:03:51');
INSERT INTO `pengajuan_dokumen` (`id`, `pengajuan_id`, `persyaratan_id`, `nama_file`, `path_file`, `mime_type`, `ukuran_file`, `created_at`, `updated_at`) VALUES (2, 4, 2, 'Screenshot 2026-03-06 at 11.55.49.png', 'pengajuan/4/WiotTS1iH2tPJQLB4TIrtjaaYHoR6uMRZrn43XmA.png', 'image/png', 268678, '2026-03-08 09:03:57', '2026-03-08 09:03:57');
INSERT INTO `pengajuan_dokumen` (`id`, `pengajuan_id`, `persyaratan_id`, `nama_file`, `path_file`, `mime_type`, `ukuran_file`, `created_at`, `updated_at`) VALUES (3, 6, 1, '1772974295_Screenshot 2026-03-05 at 10.25.14.png', 'pengajuan_dokumen/1772974295_Screenshot 2026-03-05 at 10.25.14.png', 'image/png', 283454, '2026-03-08 12:51:35', '2026-03-08 12:51:35');
INSERT INTO `pengajuan_dokumen` (`id`, `pengajuan_id`, `persyaratan_id`, `nama_file`, `path_file`, `mime_type`, `ukuran_file`, `created_at`, `updated_at`) VALUES (4, 6, 2, '1772974295_Screenshot 2026-03-06 at 15.14.47.png', 'pengajuan_dokumen/1772974295_Screenshot 2026-03-06 at 15.14.47.png', 'image/png', 93450, '2026-03-08 12:51:35', '2026-03-08 12:51:35');
COMMIT;

-- ----------------------------
-- Table structure for pengajuan_status_histories
-- ----------------------------
DROP TABLE IF EXISTS `pengajuan_status_histories`;
CREATE TABLE `pengajuan_status_histories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `pengajuan_id` bigint unsigned NOT NULL,
  `status` enum('menunggu','diproses','selesai','ditolak') COLLATE utf8mb4_unicode_ci NOT NULL,
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `user_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pengajuan_status_histories_user_id_foreign` (`user_id`),
  KEY `pengajuan_status_histories_pengajuan_id_index` (`pengajuan_id`),
  KEY `pengajuan_status_histories_status_index` (`status`),
  KEY `pengajuan_status_histories_created_at_index` (`created_at`),
  CONSTRAINT `pengajuan_status_histories_pengajuan_id_foreign` FOREIGN KEY (`pengajuan_id`) REFERENCES `pengajuans` (`id`) ON DELETE CASCADE,
  CONSTRAINT `pengajuan_status_histories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of pengajuan_status_histories
-- ----------------------------
BEGIN;
INSERT INTO `pengajuan_status_histories` (`id`, `pengajuan_id`, `status`, `catatan`, `user_id`, `created_at`, `updated_at`) VALUES (1, 1, 'menunggu', 'Pengajuan dibuat', 1, '2026-03-08 08:18:57', '2026-03-08 08:18:57');
INSERT INTO `pengajuan_status_histories` (`id`, `pengajuan_id`, `status`, `catatan`, `user_id`, `created_at`, `updated_at`) VALUES (2, 2, 'menunggu', 'Pengajuan dibuat', 1, '2026-03-08 08:19:40', '2026-03-08 08:19:40');
INSERT INTO `pengajuan_status_histories` (`id`, `pengajuan_id`, `status`, `catatan`, `user_id`, `created_at`, `updated_at`) VALUES (3, 2, 'diproses', NULL, 1, '2026-03-08 08:24:41', '2026-03-08 08:24:41');
INSERT INTO `pengajuan_status_histories` (`id`, `pengajuan_id`, `status`, `catatan`, `user_id`, `created_at`, `updated_at`) VALUES (4, 3, 'menunggu', 'Pengajuan dibuat', 1, '2026-03-08 08:25:55', '2026-03-08 08:25:55');
INSERT INTO `pengajuan_status_histories` (`id`, `pengajuan_id`, `status`, `catatan`, `user_id`, `created_at`, `updated_at`) VALUES (5, 4, 'menunggu', 'Pengajuan dibuat', 1, '2026-03-08 08:34:47', '2026-03-08 08:34:47');
INSERT INTO `pengajuan_status_histories` (`id`, `pengajuan_id`, `status`, `catatan`, `user_id`, `created_at`, `updated_at`) VALUES (6, 5, 'menunggu', NULL, NULL, '2026-03-08 12:23:45', '2026-03-08 12:23:45');
INSERT INTO `pengajuan_status_histories` (`id`, `pengajuan_id`, `status`, `catatan`, `user_id`, `created_at`, `updated_at`) VALUES (7, 6, 'menunggu', NULL, NULL, '2026-03-08 12:51:35', '2026-03-08 12:51:35');
COMMIT;

-- ----------------------------
-- Table structure for pengajuans
-- ----------------------------
DROP TABLE IF EXISTS `pengajuans`;
CREATE TABLE `pengajuans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nomor` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `penduduk_id` bigint unsigned NOT NULL,
  `layanan_id` bigint unsigned NOT NULL,
  `tanggal` date NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `status` enum('menunggu','diproses','selesai','ditolak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'menunggu',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pengajuans_nomor_unique` (`nomor`),
  KEY `pengajuans_nomor_index` (`nomor`),
  KEY `pengajuans_penduduk_id_index` (`penduduk_id`),
  KEY `pengajuans_layanan_id_index` (`layanan_id`),
  KEY `pengajuans_status_index` (`status`),
  KEY `pengajuans_tanggal_index` (`tanggal`),
  CONSTRAINT `pengajuans_layanan_id_foreign` FOREIGN KEY (`layanan_id`) REFERENCES `layanans` (`id`) ON DELETE CASCADE,
  CONSTRAINT `pengajuans_penduduk_id_foreign` FOREIGN KEY (`penduduk_id`) REFERENCES `penduduks` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of pengajuans
-- ----------------------------
BEGIN;
INSERT INTO `pengajuans` (`id`, `nomor`, `penduduk_id`, `layanan_id`, `tanggal`, `keterangan`, `status`, `created_at`, `updated_at`) VALUES (1, 'PGJ202603080515B0', 2, 1, '2026-03-08', '---', 'menunggu', '2026-03-08 08:18:57', '2026-03-08 08:18:57');
INSERT INTO `pengajuans` (`id`, `nomor`, `penduduk_id`, `layanan_id`, `tanggal`, `keterangan`, `status`, `created_at`, `updated_at`) VALUES (2, 'PGJ20260308F34051', 47, 1, '2026-03-08', NULL, 'diproses', '2026-03-08 08:19:40', '2026-03-08 08:24:41');
INSERT INTO `pengajuans` (`id`, `nomor`, `penduduk_id`, `layanan_id`, `tanggal`, `keterangan`, `status`, `created_at`, `updated_at`) VALUES (3, 'PGJ2026030889A441', 28, 1, '2026-03-08', NULL, 'menunggu', '2026-03-08 08:25:55', '2026-03-08 08:25:55');
INSERT INTO `pengajuans` (`id`, `nomor`, `penduduk_id`, `layanan_id`, `tanggal`, `keterangan`, `status`, `created_at`, `updated_at`) VALUES (4, 'PGJ20260308506508', 2, 1, '2026-03-08', NULL, 'menunggu', '2026-03-08 08:34:47', '2026-03-08 08:34:47');
INSERT INTO `pengajuans` (`id`, `nomor`, `penduduk_id`, `layanan_id`, `tanggal`, `keterangan`, `status`, `created_at`, `updated_at`) VALUES (5, 'SUR-20260308-0005', 56, 1, '2026-03-08', 'uh', 'menunggu', '2026-03-08 12:23:45', '2026-03-08 12:23:45');
INSERT INTO `pengajuans` (`id`, `nomor`, `penduduk_id`, `layanan_id`, `tanggal`, `keterangan`, `status`, `created_at`, `updated_at`) VALUES (6, 'SUR-20260308-0006', 56, 1, '2026-03-08', NULL, 'menunggu', '2026-03-08 12:51:35', '2026-03-08 12:51:35');
COMMIT;

-- ----------------------------
-- Table structure for persyaratans
-- ----------------------------
DROP TABLE IF EXISTS `persyaratans`;
CREATE TABLE `persyaratans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `layanan_id` bigint unsigned NOT NULL,
  `nama_dokumen` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `tipe_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Contoh: pdf,jpg,png',
  `max_size` int DEFAULT NULL COMMENT 'Ukuran maksimum dalam KB',
  `wajib` tinyint(1) NOT NULL DEFAULT '1',
  `urutan` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `persyaratans_layanan_id_index` (`layanan_id`),
  KEY `persyaratans_urutan_index` (`urutan`),
  CONSTRAINT `persyaratans_layanan_id_foreign` FOREIGN KEY (`layanan_id`) REFERENCES `layanans` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of persyaratans
-- ----------------------------
BEGIN;
INSERT INTO `persyaratans` (`id`, `layanan_id`, `nama_dokumen`, `keterangan`, `tipe_file`, `max_size`, `wajib`, `urutan`, `created_at`, `updated_at`) VALUES (1, 1, 'KTP', NULL, NULL, NULL, 0, 1, '2026-03-08 07:53:27', '2026-03-08 07:53:27');
INSERT INTO `persyaratans` (`id`, `layanan_id`, `nama_dokumen`, `keterangan`, `tipe_file`, `max_size`, `wajib`, `urutan`, `created_at`, `updated_at`) VALUES (2, 1, 'Surat Pengantar RT', NULL, NULL, NULL, 0, 2, '2026-03-08 07:53:44', '2026-03-08 07:53:44');
COMMIT;

-- ----------------------------
-- Table structure for profil_desas
-- ----------------------------
DROP TABLE IF EXISTS `profil_desas`;
CREATE TABLE `profil_desas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_desa` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kecamatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat_kantor` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_kepala_desa` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nip_kepala_desa` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of profil_desas
-- ----------------------------
BEGIN;
INSERT INTO `profil_desas` (`id`, `nama_desa`, `kecamatan`, `alamat_kantor`, `nama_kepala_desa`, `nip_kepala_desa`, `created_at`, `updated_at`) VALUES (1, 'desa kresik', '-', 'Jl. Dharma Praja RT. 08 Kec. Batulicin, Kab. Tanah Bumbu', 'udin', '111111111111111111', '2026-03-08 09:14:09', '2026-03-08 09:14:09');
COMMIT;

-- ----------------------------
-- Table structure for sessions
-- ----------------------------
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of sessions
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for surats
-- ----------------------------
DROP TABLE IF EXISTS `surats`;
CREATE TABLE `surats` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nomor_surat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_surat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_surat` date NOT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `surats_nomor_surat_unique` (`nomor_surat`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of surats
-- ----------------------------
BEGIN;
INSERT INTO `surats` (`id`, `nomor_surat`, `jenis_surat`, `tanggal_surat`, `file`, `created_at`, `updated_at`) VALUES (1, '24323', 'Surat Pengantar', '2026-03-09', 'surat/1772961729_rekoran_oktober.pdf', '2026-03-08 09:22:09', '2026-03-08 09:27:03');
COMMIT;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'MASYARAKAT',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
BEGIN;
INSERT INTO `users` (`id`, `name`, `username`, `role`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (1, 'Administrator', 'admin', 'ADMIN', '$2y$12$Vl0PV4YJKXUrqycmXgPRNeM4arezYWxwin2rIo3mC.RmXMsCLueEa', NULL, '2026-03-08 06:24:51', '2026-03-08 06:24:51');
INSERT INTO `users` (`id`, `name`, `username`, `role`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (2, 'Kepala Desa', 'kepala_desa', 'KEPALA_DESA', '$2y$12$GWwuZWRs.pBhinpQtWf92O448TzEWX2kdruSxsm1ls9to8WxuCby2', NULL, '2026-03-08 06:24:52', '2026-03-08 06:24:52');
INSERT INTO `users` (`id`, `name`, `username`, `role`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (3, 'Masyarakat', 'masyarakat', 'MASYARAKAT', '$2y$12$BMKPcCSzXMrpmm.pqTVgE..LUn7een1kjF/UrDfNmqegaxAxl8JWe', NULL, '2026-03-08 06:24:52', '2026-03-08 06:24:52');
INSERT INTO `users` (`id`, `name`, `username`, `role`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (6, 'sad', '5647543245654326', 'MASYARAKAT', '$2y$12$u2yahdCcAYLu8E4P4yv5p.Xnl7RO/ahXq4VA9//Jrp0vWAMxh.bue', NULL, '2026-03-08 11:47:57', '2026-03-08 11:47:57');
INSERT INTO `users` (`id`, `name`, `username`, `role`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (7, 'andi', '2332454324534242', 'MASYARAKAT', '$2y$12$ZNZ5rpc27frLa9MuXV/qYOKDR6554A51Ot3d1fXylGdvFQL..jSKi', NULL, '2026-03-08 12:02:06', '2026-03-08 12:02:06');
INSERT INTO `users` (`id`, `name`, `username`, `role`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (8, 'Asrani no last name', '6371030807720012', 'MASYARAKAT', '$2y$12$BTeEbZDIo.zphDiuitzekOmhJI4o2cuQFPHUoGHDnZEG6.Bu7jM1e', NULL, '2026-03-08 12:05:50', '2026-03-08 12:05:50');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
