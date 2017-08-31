<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ExportController
 *
 * @author Luis Miguens <lmiguens@consolidador.com>
 */

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\StreamedResponse;
use Doctrine\DBAL\Connection;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;



class ExportController
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function generateCsvAction()
{
    $response = new StreamedResponse();
    $response->setCallback(function() {
        $handle = fopen('php://output', 'w+');

        // Add the header of the CSV file
        fputcsv($handle, array('Name', 'Surname', 'Age', 'Sex'),';');
        // Query data from database
//        $results = $this->connection->query("Replace this with your query");
        // Add the data queried from database
//        while($row = $results->fetch()) {
//            fputcsv(
//                $handle, // The file pointer
//                array($row['name'], $row['surname'], $row['age'], $row['sex']), // The fields
//                ';' // The delimiter
//            );
//        }

        fclose($handle);
    });

    $response->setStatusCode(200);
    $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
    $response->headers->set('Content-Disposition', 'attachment; filename="export.csv"');

    return $response;
}


}
    