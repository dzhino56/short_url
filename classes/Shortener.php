<?php
require_once 'DBUtils.php';


class Shortener
{
    protected $pdo;

    public function __construct()
    {
        $dbUtils = new DBUtils();
        $this->pdo = $dbUtils->getPdo();
    }

    protected function generateCode($number)
    {
        return base_convert($number, 10, 36);

    }

    public function makeCode($url)
    {
        $url = trim($url);

        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return '';
        }

        //Check if URL already exists
        $stmt = $this->pdo->prepare("SELECT code FROM links WHERE url = :url");
        $stmt->execute(['url' => $url]);

        if ($data = $stmt->fetch()) {
            return $data['code'];
        } else {
            $insert = $this->pdo->prepare("INSERT INTO links (url, created) VALUES (:url, NOW())");
            $insert->execute(['url' => $url]);

            // Generate code based on inserted ID
            $code = $this->generateCode($this->pdo->lastInsertId());


            // Update the record with the generated code
            $update = $this->pdo->prepare("UPDATE links SET code = :code WHERE url = :url");
            $update->execute(['code' => $code, 'url' => $url]);
            return $code;
        }
    }

    public function getUrl($code)
    {
        $url = $this->pdo->prepare("SELECT url FROM links WHERE code = :code");
        $url->execute(['code' => $code]);

        if ($data = $url->fetch()) {
            return $data['url'];
        }
        return '';
    }
}










