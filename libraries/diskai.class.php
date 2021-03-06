<?php

require_once 'base.class.php';

class diskai extends base
{

    public function __construct()
    {

    }

    public function getId()
    {
        return 'id';
    }

    protected function getTable()
    {
        return 'diskai';
    }

    protected function getChildReference()
    {
        return ['fk_diskas'];
    }

    protected function getChildTable()
    {
        return ['sutartys'];
    }

    protected function getChildCount()
    {
        return 1;
    }

    public function getAll($limit = null, $offset = null)
    {
        $query = "  SELECT diskai.*,
                          filmai.pavadinimas AS pavadinimas,
                          padaliniai.padalinys AS padalinys
                    FROM diskai
                    INNER JOIN filmai ON filmai.id = diskai.fk_filmas
                    INNER JOIN padaliniai ON padaliniai.id = diskai.fk_vieta";
        return parent::getAllCustomQuery($query, $limit, $offset);
    }


    public function insert($data)
    {
        $query = "  INSERT INTO diskai
								(
									id,
									kiek_kartu_nuomuota,
									fk_filmas,
									fk_vieta
								)
								VALUES
								(
									'{$data['id']}',
									'{$data['kiek_kartu_nuomuota']}',
									'{$data['fk_filmas']}',
									'{$data['fk_vieta']}'
								)";
        mysql::query($query);
    }

    public function update($data)
    {
        $query = "  UPDATE diskai
					SET    kiek_kartu_nuomuota='{$data['kiek_kartu_nuomuota']}',
					       fk_filmas='{$data['fk_filmas']}',
					       fk_vieta='{$data['fk_vieta']}'
					WHERE id='{$data['id']}'";
        mysql::query($query);
    }


    public function getTableHeaders()
    {
        return ['Id', 'Filmas', 'Kiek kartu nuomuota', 'Vieta'];
    }

    public function getRowFromData($data)
    {
        return "<td>{$data['id']}</td>"
        . "<td>{$data['pavadinimas']}</td>"
        . "<td>{$data['kiek_kartu_nuomuota']}</td>"
        . "<td>{$data['padalinys']}</td>";
    }
    
    public function getSeriesSorted()
    {
        $query = "SELECT * FROM serijos ORDER BY serijos.serija ASC";

        return mysql::select($query);
        
    }
    
    public function getFilmsForSeries($id)
    {
        $query = "SELECT * FROM filmai WHERE filmai.fk_serija = {$id}";
        return mysql::select($query);
    }

    public function getCreateNewMessage()
    {
        return "Naujas diskas";
    }

    public function getPath()
    {
        return "Diskai";
    }


}