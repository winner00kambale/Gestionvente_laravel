<?php

namespace App\Http\Controllers;

use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Http\Request;

class PdfController extends Controller
{   //la facture
    public function index() 
    {
        $data = \DB::select("SELECT * FROM panier");
        $req1 = \DB::select("SELECT client FROM `panier` GROUP BY client ");
        $req2 = \DB::select("SELECT SUM(nombre)unites,SUM(montant)tot,CURDATE()dates FROM `panier` GROUP BY client");
            $this->fpdf = new Fpdf;
            $this->fpdf->AddPage();
    	    $this->fpdf->SetFont('Arial', 'I', 12);
            // Header
            $this->fpdf->Image('../public/img/entete2.jpg',6,5,196);
            $this->fpdf->Ln(35);
            
        foreach ($req1 as $cli) {
            $this->fpdf->Cell(175,12,'Facture de :      '.$cli->client,1,0,'C');
        }   
            $this->fpdf->Ln();
            $this->fpdf->Cell(25,6,'numero',1,0,'C');
            $this->fpdf->Cell(50,6,'Article',1,0,'C');
            $this->fpdf->Cell(50,6,'Nombre',1,0,'C');
            $this->fpdf->Cell(50,6,'montant',1,0,'C');
            $this->fpdf->Ln();
        foreach ($data as $pan) {
            $this->fpdf->Cell(25,8,$pan->id,1,0,'C');
            $this->fpdf->Cell(50,8,$pan->article,1,0,'C');
            $this->fpdf->Cell(50,8,$pan->nombre,1,0,'C');
            $this->fpdf->Cell(50,8,$pan->montant,1,0,'C');
            $this->fpdf->Ln();
        }
        foreach ($req2 as $tot) {
            $this->fpdf->Cell(175,8,'                Montant Total à payer :                  |     '  .$tot->tot. '    USD',1,0,'C');
            $this->fpdf->Ln();
            $this->fpdf->Cell(37,12,' Day : '.$tot->dates,0,0,'C');        
        }
        \DB::delete('DELETE FROM panier');

        $this->fpdf->Output();
        exit;        
    }
    //Rapport journalier
    public function index_journ(){
        $rapport = \DB::select("SELECT * FROM aff_vente WHERE dates=CURDATE()");
                $this->fpdf = new Fpdf;
                $this->fpdf->AddPage();
                $this->fpdf->SetFont('Arial', 'I', 12);
                // Header
                $this->fpdf->Image('../public/img/entete2.jpg',6,5,196);
                $this->fpdf->Ln(35);
                $this->fpdf->Cell(190,12,'Rapport Journalier de vente des unites',1,0,'C');
                $this->fpdf->Ln();
                $this->fpdf->Cell(20,6,'#',1,0,'C');
                $this->fpdf->Cell(35,6,'client',1,0,'C');
                $this->fpdf->Cell(35,6,'produit',1,0,'C');
                $this->fpdf->Cell(30,6,'nombre',1,0,'C');
                $this->fpdf->Cell(25,6,'montant',1,0,'C');
                $this->fpdf->Cell(45,6,'Date du jour',1,0,'C');
                $this->fpdf->Ln();

            foreach ($rapport as $row) {
                $this->fpdf->Cell(20,8,$row->id,1,0,'C');
                $this->fpdf->Cell(35,8,$row->Client,1,0,'C');
                $this->fpdf->Cell(35,8,$row->Produit,1,0,'C');
                $this->fpdf->Cell(30,8,$row->nombre,1,0,'C');
                $this->fpdf->Cell(25,8,$row->montant,1,0,'C');
                $this->fpdf->Cell(45,8,$row->dates,1,0,'C');
                $this->fpdf->Ln();
            }
            $this->fpdf->Output();
            exit;
    }
}
