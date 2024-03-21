<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

class Database {
    private $host;
    private $dbname;
    private $username;
    private $password;

    public function __construct() {
        $this->host = $_ENV['DB_HOST'];
        $this->dbname = $_ENV['POSTGRES_DB'];
        $this->username = $_ENV['POSTGRES_USER'];
        $this->password = $_ENV['POSTGRES_PASSWORD'];
    }

    // Method to connect to the database
    public function connect() {
        $dsn = 'pgsql:host=' . $this->host . ';dbname=' . $this->dbname;
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            $pdo = new PDO($dsn, $this->username, $this->password, $options);
            return $pdo;
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }

    // Method to initialize database schema
    public function initSchema() {
        $pdo = $this->connect();

        // Create tables if they don't exist
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS users (
                id SERIAL PRIMARY KEY,
                username VARCHAR(255) NOT NULL,
                email VARCHAR(255) NOT NULL,
                password VARCHAR(255) NOT NULL,
                role INT NOT NULL DEFAULT 2
            )
        ");

        $pdo->exec("
            CREATE TABLE IF NOT EXISTS categories (
                id SERIAL PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                parent_id INT DEFAULT NULL
            )
        ");

        $pdo->exec("
            CREATE TABLE IF NOT EXISTS events (
                id SERIAL PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                city VARCHAR(255) NOT NULL,
                category_ids INT[] NOT NULL,
                featured_image VARCHAR(255) DEFAULT NULL,
                short_description TEXT,
                long_description TEXT,
                user_id INT NOT NULL,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
            )
        ");

            // Insert initial data into the categories table
        $pdo->query("
            INSERT INTO categories (name) VALUES
                ('Music Concerts'),
                ('Art Exhibitions'),
                ('Sports Events'),
                ('Workshops & Seminars'),
                ('Food Festivals'),
                ('Comedy Shows'),
                ('Technology Conferences'),
                ('Fashion Shows'),
                ('Charity Events'),
                ('Film Screenings')
            ON CONFLICT DO NOTHING
        ");
    }
}
?>