<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ReportController
 *
 * @author TIA.WICAKSONO
 */
class CisController extends Controller {

    //put your code here
    public $layout = '//layouts/main_android';
    public function actionIndex() {
        $this->pageTitle = 'Status Proses';
        $this->render('cis');
    }
    
    public function actionPrauji() {
        $this->render('prauji');
    }
    
    public function actionRem() {
        $this->render('rem');
    }
    
    public function actionLampu() {
        $this->render('lampu');
    }
    
    public function actionEmisi() {
        $this->render('emisi');
    }
    
    public function actionPitlift() {
        $this->render('pitlift');
    }

    public function actionAll() {
        $this->render('all');
    }

}
