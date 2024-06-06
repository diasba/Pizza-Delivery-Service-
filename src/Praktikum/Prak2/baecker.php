<?php declare(strict_types=1);
require_once './Page.php';

class Baecker extends Page
{
    protected function __construct()
    {
        parent::__construct();
    }

    public function __destruct()
    {
        parent::__destruct();
    }

    protected function processReceivedData():void
    {
        parent::processReceivedData();

            //$statusMap = [
            //    'Bestellt' => 1,
            //    'Im Ofen' => 2,
            //    'Fertig' => 3,
            //
            //];
            if(isset($_POST['status'])){
                foreach ($_POST['status'] as $orderedArticleId => $status) {
                    //$status = $statusMap[$status];
                    $query = "UPDATE `ordered_article` SET `status` = ? WHERE `ordered_article_id` = ?";
                    $stmt = $this->db->prepare($query);
                    $stmt->bind_param('ii', $status, $orderedArticleId);
                    $stmt->execute();
                    $stmt->close();
                }
            }
    }

    protected function getViewData():array
{
    $query = "SELECT `ordered_article`.`ordered_article_id`, `article`.`name`, `ordered_article`.`status` 
              FROM `ordered_article` 
              JOIN `article` ON `ordered_article`.`article_id` = `article`.`article_id`
              WHERE `ordered_article`.`status` = 1 OR `ordered_article`.`status` = 2 "; // Nur Pizzen abrufen, die nicht "Fertig" sind

    $result = $this->db->query($query);
    $pizzas = [];

    while ($row = $result->fetch_assoc()) {
        $pizzas[] = $row;
    }
    $result->free();

    return $pizzas;
}


    protected function generateView():void
    {
        $data = $this->getViewData();
        //$statusMap = [
        //    0 => 'NaN', 
        //    1 => 'Bestellt',
        //    2 => 'Im Ofen',
        //    3 => 'Fertig',
        //    
        //];

        $this->generatePageHeader('Bäcker'); 

        echo <<<HTML
        <h1> <b>Pizzabäcker (bestellte Pizzen)</b> </h1>
        <hr>
        
        <form method="post" action="baecker.php">
HTML;

        foreach ($data as $pizza) {
            $id = htmlspecialchars($pizza['ordered_article_id']);
            $name = htmlspecialchars($pizza['name']);
            //$status = $statusMap[$pizza['status']];
            $status = $pizza['status'];

            $checkedBestellt = $status == 1 ? 'checked' : ''; // if status is bestellt then checked else none
            $checkedImOfen = $status == 2 ? 'checked' : '';
            $checkedFertig = $status == 3 ? 'checked' : '';
            

            echo <<<HTML
            <label>
                <input type="radio" name="status[$id]" value="1" $checkedBestellt/> Bestellt
                <input type="radio" name="status[$id]" value="2" $checkedImOfen/> Im Ofen
                <input type="radio" name="status[$id]" value="3" $checkedFertig/> Fertig
               
                $name
            </label>
            <br>
HTML;
        }

        echo <<<HTML
            <input type="submit" value="Aktualisieren">
        </form>
HTML;

        $this->generatePageFooter();
    }

    public static function main():void
    {
        try {
            $page = new Baecker();
            $page->processReceivedData();
            $page->generateView();
        } catch (Exception $e) {
            header("Content-type: text/html; charset=UTF-8");
            echo $e->getMessage();
        }
    }
}

Baecker::main();
?>
