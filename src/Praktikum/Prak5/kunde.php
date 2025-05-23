<?php declare(strict_types=1);
require_once './Page.php';

class Kunde extends Page
{
    protected function __construct()
    {
        parent::__construct();
    }

    public function __destruct()
    {
        parent::__destruct();
    }

    protected function processReceivedData(): void
    {
        parent::processReceivedData();
    }

    protected function getViewData(): array
    {
        if (isset($_SESSION['orderingId'])) {
            $orderingId = $_SESSION['orderingId'];
        }

        $query = "SELECT `ordering`.`ordering_id`, `article`.`name`, `ordered_article`.`status`, ordering.address
                  FROM `ordering` 
                  JOIN `ordered_article` ON `ordering`.`ordering_id` = `ordered_article`.`ordering_id` 
                  JOIN `article` ON `ordered_article`.`article_id` = `article`.`article_id` 
                  WHERE `ordering`.`ordering_id` = ?"; // Kunde wird per Session bestimmt

        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $orderingId);
        $stmt->execute();
        $result = $stmt->get_result();
        $orders = [];

        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }
        $stmt->close();

        return $orders;
    }

    protected function generateView(): void
    {
        $this->generatePageHeader('Kunde');

        echo <<<HTML
        <h1><b>Kunde (Lieferstatus)</b></h1>
        <hr>
        <div class="order-status" id="order-status"></div>
        <a href="./bestellung.php" class="neue-bestellung">Neue Bestellung</a>
        <script src="StatusUpdate.js"></script>
HTML;

        $this->generatePageFooter();
    }

    public static function main(): void
    {
        try {
            session_start();
            $page = new Kunde();
            $page->processReceivedData();
            $page->generateView();
        } catch (Exception $e) {
            header("Content-type: text/html; charset=UTF-8");
            echo $e->getMessage();
        }
    }
}

Kunde::main();
?>
