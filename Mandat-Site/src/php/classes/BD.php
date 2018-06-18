<?php

/**
 * Created by PhpStorm.
 * User: godima
 * Date: 22.03.2017
 * Time: 12:57
 * Summary: Toutes demandes vers la BD vas passer par la class BD
 */
class BD
{
    private $user = "root";
    private $password= "";
    private $host = "localhost";
    private $dbName = "db_mandate";
    private $db;
    /***************************************
     * conection à la BD     *
     */
    private function connectBD()
    {
        try{
            $this->db = new PDO('mysql:host='.$this->host.';dbname='.$this->dbName.'',$this->user,$this->password);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e) {
            $msg = 'ERREUR PDO dans ' . $e->getFile() . ' L.' . $e->getLine() . ' : ' . $e->getMessage();
            die($msg);
        }
    } //end connectBD()

    /**********
     * deconnection à la base de données
     */
    private function disconctBD()
    {
        $this->bd = null;
    }

	/****
	 * execute query with a return
	 */
    public function executeQueryReturn($sqlQuery)
   {
		$this->connectBD();
        $sth = $this->db->prepare($sqlQuery);
        $sth->execute();
        $return = $sth->fetchAll();
        $this->disconctBD();
		return $return;
   }

	/****
	 * execute query
	 */
	public function executeQuery($sqlQuery)
	{
		$this->connectBD();
        $sth = $this->db->prepare($sqlQuery);
        $sth->execute();
        $return = $sth->fetchAll();
        $this->disconctBD();
	}
}
