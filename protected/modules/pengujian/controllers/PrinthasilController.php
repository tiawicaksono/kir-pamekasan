<?php

class PrinthasilController extends Controller
{

    public function filters()
    {
        return array(
            'Rights', // perform access control for CRUD operations
        );
    }

    /* =====================================================================
     * STATUS PROSES UJI
      ===================================================================== */

    public function actionIndex()
    {
        $this->pageTitle = 'PRINT HASIL';
        $penguji = TblNamaPenguji::model()->findAllByAttributes(array('status_penguji' => true));
        $this->render('index', array('penguji' => $penguji));
    }

    public function actionPrintHasilListGrid()
    {
        $ok = Yii::app()->baseUrl . "/images/icon_approve.png";
        $reject = Yii::app()->baseUrl . "/images/icon_reject.png";
        $proses = Yii::app()->baseUrl . "/images/icon_proccess.png";
        $kelulusan = $_POST['chooseKelulusan'];
        $cetak = $_POST['chooseCetak'];
        $textCategory = strtoupper($_POST['textCategory']);
        $tgl = $_POST['tanggal'];
        $tanggal = date("Y-m-d", strtotime($tgl));

        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 15;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'antri';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
        $offset = ($page - 1) * $rows;

        $criteria = new CDbCriteria();
        $criteria->order = "$sort $order";
        $criteria->limit = $rows;
        $criteria->offset = $offset;
        if (!empty($textCategory)) {
            $criteria->addCondition("(replace(LOWER(no_uji),' ','') like replace(LOWER('%" . $textCategory . "%'),' ','') OR replace(LOWER(no_kendaraan),' ','') like replace(LOWER('" . $textCategory . "'),' ',''))");
        }
        if ($kelulusan != 'all') {
            $criteria->addCondition("hasil = $kelulusan");
        }
        if ($cetak != 'all') {
            $criteria->addCondition("cetak = $cetak");
        }
        // $result = VStatusProses::model()->findAll($criteria);
        $criteria->addCondition("jdatang::date = '$tanggal'");
        $result = VVerifikasi::model()->findAll($criteria);
        $dataJson = array();

        foreach ($result as $p) {
            //prauji
            if ($p->prauji == "true") {
                $prauji = 1;
                if ($p->lulus_prauji == "true")
                    $img_prauji = "<img src='$ok'>";
                else
                    $img_prauji = "<img src='$reject'>";
            } else {
                $prauji = 0;
                $img_prauji = "<img src='$proses'>";
            }
            //smoke
            if ($p->smoke == "true") {
                $smoke = 1;
                if ($p->lulus_smoke == "true")
                    $img_smoke = "<img src='$ok'>";
                else
                    $img_smoke = "<img src='$reject'>";
            } else {
                $smoke = 0;
                $img_smoke = "<img src='$proses'>";
            }
            //pitlift
            if ($p->pitlift == "true") {
                $pitlift = 1;
                if ($p->lulus_pitlift == "true")
                    $img_pitlift = "<img src='$ok'>";
                else
                    $img_pitlift = "<img src='$reject'>";
            } else {
                $pitlift = 0;
                $img_pitlift = "<img src='$proses'>";
            }
            //lampu
            if ($p->lampu == "true") {
                $lampu = 1;
                if ($p->lulus_lampu == "true")
                    $img_lampu = "<img src='$ok'>";
                else
                    $img_lampu = "<img src='$reject'>";
            } else {
                $lampu = 0;
                $img_lampu = "<img src='$proses'>";
            }
            //rem
            if ($p->break == "true") {
                $break = 1;
                if ($p->lulus_break == "true")
                    $img_break = "<img src='$ok'>";
                else
                    $img_break = "<img src='$reject'>";
            } else {
                $break = 0;
                $img_break = "<img src='$proses'>";
            }

            if ($prauji == 1 && $smoke == 1 && $pitlift == 1 && $lampu == 1 && $break == 1) {
                if ($p->hasil == "true")
                    $ltl = 'l';
                else
                    $ltl = 'tl';
            } else {
                $ltl = 'proses';
            }

            $dataPrintHasil = VPrintHasil::model()->findByAttributes(array('id_hasil_uji' => $p->id_hasil_uji));
            $noSurat = '';
            $nama_penguji = '';
            if (!empty($dataPrintHasil)) {
                $noSurat = $dataPrintHasil->no_surat;
                $nama_penguji = $dataPrintHasil->nm_penguji;
            }

            $dataJson[] = array(
                "id_kendaraan" => $p->id_kendaraan,
                "kendaraan_id" => $p->id_kendaraan,
                "blokir" => $p->blokir == false ? '-' : '<font style="color:red">' . $p->keterangan_blokir . '</font>',
                "foto" => $p->id_hasil_uji,
                "hasil_uji_id" => $p->id_hasil_uji,
                "id_hasil_uji" => $p->id_hasil_uji,
                "no_antrian" => $p->no_antrian,
                "no_uji" => $p->no_uji,
                "no_kendaraan" => $p->no_kendaraan,
                "nama_pemilik" => $p->nama_pemilik,
                "nm_penguji" => $nama_penguji,
                "prauji" => $img_prauji,
                "emisi" => $img_smoke,
                "pitlift" => $img_pitlift,
                "lampu" => $img_lampu,
                "rem" => $img_break,
                "cetak" => $ltl . "|" . $p->id_hasil_uji . "|" . $noSurat . "|" . $p->no_seri
            );
        }
        header('Content-Type: application/json');
        echo CJSON::encode(
            array(
                'total' => VVerifikasi::model()->count($criteria),
                'rows' => $dataJson,
            )
        );
        Yii::app()->end();
    }

    public function actionCetaktl($id, $nosurat, $nrp)
    {
        $this->layout = '//';
        Yii::app()->session->add('ses_no_surat', $nosurat);
        //        Yii::app()->session->add('ses_nrp', $nrp);
        //PENGUJI
        $tblPenguji = TblNamaPenguji::model()->findByAttributes(array('nrp' => $nrp));
        $nm_penguji = $tblPenguji['nama_penguji'];
        $jabatan = $tblPenguji['jabatan'];
        $jam_selesai = date('m/d/Y g:i:s');

        $tblHasilUji = TblHasilUji::model()->findByAttributes(array('id_hasil_uji' => $id));
        $query = Yii::app()->db->createCommand('select get_no_tl()')->queryRow();
        $no_tl = $query['get_no_tl'];

        if ($tblHasilUji->no_tl == 0 || empty($tblHasilUji->no_tl) || ($tblHasilUji->no_tl === NULL) || is_null($tblHasilUji->no_tl)) {
            $sql = "UPDATE tbl_hasil_uji SET nm_penguji='$nm_penguji', jabatan = '$jabatan', jselesai = '$jam_selesai', no_surat = '$nosurat', cetak = 'true', nrp = '$nrp', no_tl=$no_tl WHERE id_hasil_uji = $id";
        } else {
            $sql = "UPDATE tbl_hasil_uji SET nm_penguji='$nm_penguji', jabatan = '$jabatan', jselesai = '$jam_selesai', no_surat = '$nosurat', cetak = 'true', nrp = '$nrp'  WHERE id_hasil_uji = $id";
        }
        Yii::app()->db->createCommand($sql)->query();

        $sql_daftar = "UPDATE tbl_daftar SET lulus = 'false' where id_daftar = $tblHasilUji->id_daftar";
        Yii::app()->db->createCommand($sql_daftar)->query();
        $this->render('cetak_tl', array('id' => $id, 'nosurat' => $nosurat, 'nrp' => $nrp));
    }

    public function actionSaveCetakl()
    {
        $no_seri_kartu = $_POST['no_seri_kartu'];
        $id = $_POST['id'];
        $posisi = $_POST['posisi'];
        $nrp = $_POST['penguji'];
        $username = Yii::app()->session['username'];
        $selectIdDaftar = TblHasilUji::model()->findByAttributes(array('id_hasil_uji' => $id))->id_daftar;
        $countTblProses = TblProses::model()->findByAttributes(array('id_daftar' => $selectIdDaftar));
        if (!empty($countTblProses)) {
            $sqlPtgPrint = "update tbl_proses set ptgs_print_hasil='$username' where id_daftar=$selectIdDaftar";
            Yii::app()->db->createCommand($sqlPtgPrint)->execute();
        }
        $dtHasilUji = VPrintHasil::model()->findByAttributes(array('id_hasil_uji' => $id));
        if (!empty($no_seri_kartu)) {

            $id_retribusi = $dtHasilUji->id_retribusi;
            $tgl_cetak = date('m/d/Y');
            $no_seris = strtoupper($no_seri_kartu);
            $var_no_seri = str_replace("'", " ", $no_seris);
            $var_nomor_seri = preg_replace("/([[:alpha:]])([[:digit:]])/", "\\1 \\2", $var_no_seri);
            $no_seri = preg_replace("/([[:digit:]])([[:alpha:]])/", "\\1 \\2", $var_nomor_seri);
            $countTblBuku = TblBuku::model()->findByAttributes(array('id_retribusi' => $id_retribusi));
            if (empty($countTblBuku)) {
                $insertTblBuku = "INSERT INTO tbl_buku(petugas,id_retribusi,no_seri,cetak,tgl_cetak) VALUES('$username',$id_retribusi,'$no_seri',true,'$tgl_cetak')";
                Yii::app()->db->createCommand($insertTblBuku)->execute();
            } else {
                $insertTblBuku = "UPDATE tbl_buku SET petugas = '$username',no_seri = '$no_seri',cetak = true,tgl_cetak = '$tgl_cetak' WHERE id_retribusi = $id_retribusi";
                Yii::app()->db->createCommand($insertTblBuku)->execute();
            }
        }
        //PENGUJI
        $tblPenguji = Penguji::model()->findByAttributes(array('nrp' => $nrp));
        $nm_penguji = $tblPenguji['nama'];
        $jabatan = $tblPenguji['pangkat'];
        $jam_selesai = date('m/d/Y g:i:s');

        $tblHasilUji = TblHasilUji::model()->findByAttributes(array('id_hasil_uji' => $id));
        $sql = "UPDATE tbl_hasil_uji SET nm_penguji='$nm_penguji', jabatan = '$jabatan', jselesai = '$jam_selesai', cetak = 'true', nrp = '$nrp'  WHERE id_hasil_uji = $id";
        Yii::app()->db->createCommand($sql)->query();
        $today = date('Y-m-d');
        //            ==============
        //            CARA 1
        //            ==============
        $tgl_mati_uji = date('n/j/Y', strtotime('+6 month', strtotime($today)));
        //            ==============
        //            CARA 2
        //            ==============
        //            $tambah_tanggal = mktime(0,0,0,date('m')+6);
        //            $tgl_mati_uji = date('n/j/Y',$tambah_tanggal);
        //            ==============
        //            CARA 3
        //            ==============
        //            $date = date_create($today);
        //            date_add($date, date_interval_create_from_date_string('6 months'));
        //            $tgl_mati_uji = date_format($date, 'n/j/Y');
        $sql_mati_uji = "UPDATE tbl_kendaraan SET tgl_mati_uji = '$tgl_mati_uji' where id_kendaraan = $tblHasilUji->id_kendaraan";
        Yii::app()->db->createCommand($sql_mati_uji)->query();
        $sql_daftar = "UPDATE tbl_daftar SET lulus = 'true' where id_daftar = $tblHasilUji->id_daftar";
        Yii::app()->db->createCommand($sql_daftar)->query();
        /*
         * CREATE RIWAYAT
         */
        $cekRiwayat = TblRiwayat::model()->findByAttributes(array('id_hasil_uji' => $id));
        if (!empty($cekRiwayat)) {
            $sql_riwayat = "UPDATE tbl_riwayat SET nama_penguji='$nm_penguji', nrp = '$nrp'  WHERE id_hasil_uji = $id";
            Yii::app()->db->createCommand($sql_riwayat)->query();
        } else {
            $modelRiwayat = new TblRiwayat();
            $modelRiwayat->tgl_uji = date("m/d/Y");
            $modelRiwayat->tempat = 'PAMEKASAN';
            $modelRiwayat->catatan = '';
            $modelRiwayat->nama_penguji = $nm_penguji;
            $modelRiwayat->id_hasil_uji = $id;
            $modelRiwayat->id_kendaraan = $tblHasilUji->id_kendaraan;
            $modelRiwayat->nrp = $nrp;
            $modelRiwayat->stts_kirim = 0;
            $modelRiwayat->save();
        }

        //INSERT FOTO MENTAH
        $cekFotoMentah = Fotomentah::model()->findByAttributes(array('nouji' => $dtHasilUji->no_uji));
        if (!empty($cekFotoMentah)) {
            $sql = "UPDATE fotomentah SET fotodepanmentah = decode('$dtHasilUji->img_depan','base64'), fotobelakangmentah = decode('$dtHasilUji->img_belakang','base64'), fotokananmentah = decode('$dtHasilUji->img_kanan','base64'), fotokirimentah = decode('$dtHasilUji->img_kiri','base64') WHERE nouji = '$dtHasilUji->no_uji'";
            Yii::app()->db->createCommand($sql)->execute();
        } else {
            $sql = "INSERT INTO fotomentah(nouji,fotodepanmentah,fotobelakangmentah,fotokananmentah,fotokirimentah) VALUES ('$dtHasilUji->no_uji',decode('$dtHasilUji->img_depan','base64'),decode('$dtHasilUji->img_belakang','base64'),decode('$dtHasilUji->img_kanan','base64'),decode('$dtHasilUji->img_kiri','base64'))";
            Yii::app()->db->createCommand($sql)->execute();
        }

        //INSERT TABEL DATAPENGUJIAN - KEMENTRIAN
        $dtRetribusi = TblRetribusi::model()->findByAttributes(array('id_retribusi' => $dtHasilUji->id_retribusi));
        $jenis_uji = $dtRetribusi->id_uji;
        $id_direktur = Direktur::model()->find()->idx;
        $id_kepaladinas = Kepaladinas::model()->find()->idx;
        $id_petugasuji = Penguji::model()->findByAttributes(array('nrp' => $nrp))->idx;
        /*
         * 1. DAFTAR BARU
         * 2. PERPANJANGAN
         * 3. PENGGANTIAN KARENA RUSAK
         * 4. PENGGANTIAN KARENA HILANG
         * 5. NUMPANG UJI MASUK
         * 6. MUTASI MASUK
         */
        $kode_wilayah_asal = 'PMKSN';
        if ($jenis_uji == 8) {
            $statuspenerbitan = 1;
        } elseif ($jenis_uji == 1 || $jenis_uji == 22 || $jenis_uji == 23) {
            $statuspenerbitan = 2;
        } elseif ($jenis_uji == 2) {
            $statuspenerbitan = 5;
            $kode_wilayah_asal = $dtRetribusi->wilayah_asal_kode;
        } elseif ($jenis_uji == 4) {
            $statuspenerbitan = 6;
            $kode_wilayah_asal = $dtRetribusi->wilayah_asal_kode;
        }
        /*
         * JBKI
         */
        $jbki = '-';
        //        if($dtHasilUji->id_jns_kend == 5){
        //            $jbki = '-';
        //        }
        $tglUji = date('dmY', strtotime($dtHasilUji->jdatang));
        $arrDtPengujian = new CDbCriteria();
        $arrDtPengujian->addCondition("tgluji = '$tglUji'");
        $arrDtPengujian->addCondition("nouji = '$dtHasilUji->no_uji'");
        $cekDtPengujian = Datapengujian::model()->find($arrDtPengujian);

        $statuspenerbitan = $statuspenerbitan;
        $nouji = $dtHasilUji->no_uji;
        $nama = $dtHasilUji->nama_pemilik;
        $noidentitaspemilik = $dtHasilUji->no_identitas;
        if (empty($dtHasilUji->no_identitas)) {
            $noidentitaspemilik = NULL;
        }
        $alamat = ucwords(strtolower($dtHasilUji->alamat));
        $nosertifikatreg = $dtHasilUji->no_regis;
        $tglsertifikatreg = date('dmY', strtotime($dtHasilUji->tgl_regis));
        $noregistrasikendaraan = $dtHasilUji->no_kendaraan;
        $norangka = $dtHasilUji->no_chasis;
        $nomesin = $dtHasilUji->no_mesin;
        $merek = $dtHasilUji->merk;
        $tipe = $dtHasilUji->tipe;
        $jenis = $dtHasilUji->karoseri_jenis;
        $thpembuatan = $dtHasilUji->tahun;
        $bahanbakar = $dtHasilUji->bahan_bakar;
        $isisilinder = $dtHasilUji->isi_silinder;
        $dayamotorpenggerak = $dtHasilUji->daya_motor;
        $jbb = $dtHasilUji->kemjbb;
        $jbkb = $dtHasilUji->kemjbkb;
        $jbi = $dtHasilUji->jbi;
        $jbki = $jbki;
        $mst = $dtHasilUji->mst;
        $beratkosong = $dtHasilUji->berat_kosong;
        $konfigurasisumburoda = $dtHasilUji->konsumbu;
        $ukuranban = $dtHasilUji->psumbu1;
        $panjangkendaraan = $dtHasilUji->ukuran_panjang;
        $lebarkendaraan = $dtHasilUji->ukuran_lebar;
        $tinggikendaraan = $dtHasilUji->ukuran_tinggi;
        $panjangbakatautangki = $dtHasilUji->dimpanjang;
        $lebarbakatautangki = $dtHasilUji->dimlebar;
        $tinggibakatautangki = $dtHasilUji->dimtinggi;
        $julurdepan = $dtHasilUji->foh;
        $julurbelakang = $dtHasilUji->roh;
        $jaraksumbu1_2 = $dtHasilUji->jsumbu1;
        $jaraksumbu2_3 = $dtHasilUji->jsumbu2;
        $jaraksumbu3_4 = $dtHasilUji->jsumbu3;
        $dayaangkutorang = $dtHasilUji->karoseri_duduk;
        $dayaangkutbarang = $dtHasilUji->kembarang;
        $kelasjalanterendah = $dtHasilUji->kls_jln;
        $idpetugasuji = $id_petugasuji;
        $idkepaladinas = $id_kepaladinas;
        $iddirektur = $id_direktur;
        $kodewilayah = 'PMKSN';
        $kodewilayahasal = $kode_wilayah_asal;
        $huv_nomordankondisirangka = 1;
        $huv_nomordantipemotorpenggerak = 1;
        $huv_kondisitangkicorongdanpipabahanbakar = 1;
        $huv_kondisiconverterkit = 1;
        $huv_kondisidanposisipipapembuangan = 1;
        $huv_ukurandankondisiban = 1;
        $huv_kondisisistemsuspensi = 1;
        $huv_kondisisistemremutama = 1;
        $huv_kondisipenutuplampudanalatpantulcahaya = 1;
        $huv_kondisipanelinstrumentdashboard = 1;
        $huv_kondisikacaspion = 1;
        $huv_kondisispakbor = 1;
        $huv_bentukbumper = 1;
        $huv_keberadaandankondisiperlengkapan = 1;
        $huv_rancanganteknis = 1;
        $huv_keberadaandankondisifasilitastanggapdaruratuntukmobilbus = 1;
        $huv_kondisibadankacaengseltempatdudukmbarangbakmuatantertutup = 1;
        $hum_kondisipenerusdaya = 1;
        $hum_sudutbebaskemudi = 1;
        $hum_kondisiremparkir = 1;
        $hum_fungsilampudanalatpantulcahaya = 1;
        $hum_fungsipenghapuskaca = 1;
        $hum_tingkatkegelapankaca = 1;
        $hum_fungsiklakson = 1;
        $hum_kondisidanfungsisabukkeselamatan = 1;
        $hum_ukurankendaraan = 1;
        $hum_ukurantempatdudukdanbagiandalamkendaraanuntukmobilbus = 1;
        $alatuji_emisiasapbahanbakarsolar = $dtHasilUji->ems_diesel;
        $alatuji_emisicobahanbakarbensin = $dtHasilUji->ems_mesin_co;
        $alatuji_emisihcbahanbakarbensin = $dtHasilUji->ems_mesin_hc;
        $alatuji_remutamatotalgayapengereman = $dtHasilUji->beratgaya;
        $alatuji_remutamaselisihgayapengeremanrodakirikanan1 = $dtHasilUji->selgaya;
        $alatuji_remutamaselisihgayapengeremanrodakirikanan2 = $dtHasilUji->selkirikanan;
        $alatuji_remutamaselisihgayapengeremanrodakirikanan3 = $dtHasilUji->selgaya3;
        $alatuji_remutamaselisihgayapengeremanrodakirikanan4 = $dtHasilUji->selgaya4;
        //M.PENUMPANG
        if ($dtHasilUji->id_jns_kend == 1) {
            $alatuji_remparkirkaki = rand(16, 100);
            $alatuji_remparkirtangan = rand(16, 100);
            //M.BARANG, DLL	
        } else {
            $alatuji_remparkirkaki = rand(12, 100);
            $alatuji_remparkirtangan = rand(12, 100);
        }
        $alatuji_kincuprodadepan = rand(1, 5);
        $alatuji_tingkatkebisingan = rand(83, 118);
        $alatuji_lampuutamakekuatanpancarlampukanan = $dtHasilUji->ktlamp_kanan;
        $alatuji_lampuutamakekuatanpancarlampukiri = $dtHasilUji->ktlamp_kiri;
        $alatuji_lampuutamapenyimpanganlampukanan = number_format($dtHasilUji->dev_kanan, 2, '.', '.');
        $alatuji_lampuutamapenyimpanganlampukiri = number_format($dtHasilUji->dev_kiri, 2, '.', '.');
        $alatuji_penunjukkecepatan = 40;
        $alatuji_kedalamanalurban = rand(1, 15);
        $masaberlakuuji = date('dmY', strtotime($dtHasilUji->tgl_mati_uji));
        $tgluji = date('dmY', strtotime($dtHasilUji->tgl_uji));
        $statuslulusuji = TRUE;

        if (empty($cekDtPengujian)) {
            $sql = "INSERT INTO datapengujian (statuspenerbitan,nouji,nama,alamat,noidentitaspemilik,nosertifikatreg,tglsertifikatreg,noregistrasikendaraan,norangka,nomesin,merek,tipe,jenis,thpembuatan,bahanbakar,isisilinder,dayamotorpenggerak,jbb,jbkb,jbi,jbki,mst,beratkosong,konfigurasisumburoda,ukuranban,panjangkendaraan,lebarkendaraan,tinggikendaraan,panjangbakatautangki,lebarbakatautangki,tinggibakatautangki,julurdepan,julurbelakang,jaraksumbu1_2,jaraksumbu2_3,jaraksumbu3_4,dayaangkutorang,dayaangkutbarang,kelasjalanterendah,idpetugasuji,idkepaladinas,iddirektur,kodewilayah,kodewilayahasal,huv_nomordankondisirangka,huv_nomordantipemotorpenggerak,huv_kondisitangkicorongdanpipabahanbakar,huv_kondisiconverterkit,huv_kondisidanposisipipapembuangan,huv_ukurandankondisiban,huv_kondisisistemsuspensi,huv_kondisisistemremutama,huv_kondisipenutuplampudanalatpantulcahaya,huv_kondisipanelinstrumentdashboard,huv_kondisikacaspion,huv_kondisispakbor,huv_bentukbumper,huv_keberadaandankondisiperlengkapan,huv_rancanganteknis,huv_keberadaandankondisifasilitastanggapdaruratuntukmobilbus,huv_kondisibadankacaengseltempatdudukmbarangbakmuatantertutup,hum_kondisipenerusdaya,hum_sudutbebaskemudi,hum_kondisiremparkir,hum_fungsilampudanalatpantulcahaya,hum_fungsipenghapuskaca,hum_tingkatkegelapankaca,hum_fungsiklakson,hum_kondisidanfungsisabukkeselamatan,hum_ukurankendaraan,hum_ukurantempatdudukdanbagiandalamkendaraanuntukmobilbus,alatuji_emisiasapbahanbakarsolar,alatuji_emisicobahanbakarbensin,alatuji_emisihcbahanbakarbensin,alatuji_remutamatotalgayapengereman,alatuji_remutamaselisihgayapengeremanrodakirikanan1,alatuji_remutamaselisihgayapengeremanrodakirikanan2,alatuji_remutamaselisihgayapengeremanrodakirikanan3,alatuji_remutamaselisihgayapengeremanrodakirikanan4,alatuji_remparkirtangan,alatuji_remparkirkaki,alatuji_kincuprodadepan,alatuji_tingkatkebisingan,alatuji_lampuutamakekuatanpancarlampukanan,alatuji_lampuutamakekuatanpancarlampukiri,alatuji_lampuutamapenyimpanganlampukanan,alatuji_lampuutamapenyimpanganlampukiri,alatuji_penunjukkecepatan,alatuji_kedalamanalurban,masaberlakuuji,tgluji,statuslulusuji) VALUES ('$statuspenerbitan','$nouji','$nama','$alamat','$noidentitaspemilik','$nosertifikatreg','$tglsertifikatreg','$noregistrasikendaraan','$norangka','$nomesin','$merek','$tipe','$jenis','$thpembuatan','$bahanbakar','$isisilinder','$dayamotorpenggerak','$jbb','$jbkb','$jbi','$jbki','$mst','$beratkosong','$konfigurasisumburoda','$ukuranban','$panjangkendaraan','$lebarkendaraan','$tinggikendaraan','$panjangbakatautangki','$lebarbakatautangki','$tinggibakatautangki','$julurdepan','$julurbelakang','$jaraksumbu1_2','$jaraksumbu2_3','$jaraksumbu3_4','$dayaangkutorang','$dayaangkutbarang','$kelasjalanterendah',$idpetugasuji,$idkepaladinas,$iddirektur,'$kodewilayah','$kodewilayahasal','$huv_nomordankondisirangka','$huv_nomordantipemotorpenggerak','$huv_kondisitangkicorongdanpipabahanbakar','$huv_kondisiconverterkit','$huv_kondisidanposisipipapembuangan','$huv_ukurandankondisiban','$huv_kondisisistemsuspensi','$huv_kondisisistemremutama','$huv_kondisipenutuplampudanalatpantulcahaya','$huv_kondisipanelinstrumentdashboard','$huv_kondisikacaspion','$huv_kondisispakbor','$huv_bentukbumper','$huv_keberadaandankondisiperlengkapan','$huv_rancanganteknis','$huv_keberadaandankondisifasilitastanggapdaruratuntukmobilbus','$huv_kondisibadankacaengseltempatdudukmbarangbakmuatantertutup','$hum_kondisipenerusdaya','$hum_sudutbebaskemudi','$hum_kondisiremparkir','$hum_fungsilampudanalatpantulcahaya','$hum_fungsipenghapuskaca','$hum_tingkatkegelapankaca','$hum_fungsiklakson','$hum_kondisidanfungsisabukkeselamatan','$hum_ukurankendaraan','$hum_ukurantempatdudukdanbagiandalamkendaraanuntukmobilbus','$alatuji_emisiasapbahanbakarsolar','$alatuji_emisicobahanbakarbensin','$alatuji_emisihcbahanbakarbensin','$alatuji_remutamatotalgayapengereman','$alatuji_remutamaselisihgayapengeremanrodakirikanan1','$alatuji_remutamaselisihgayapengeremanrodakirikanan2','$alatuji_remutamaselisihgayapengeremanrodakirikanan3','$alatuji_remutamaselisihgayapengeremanrodakirikanan4','$alatuji_remparkirtangan','$alatuji_remparkirkaki','$alatuji_kincuprodadepan','$alatuji_tingkatkebisingan','$alatuji_lampuutamakekuatanpancarlampukanan','$alatuji_lampuutamakekuatanpancarlampukiri','$alatuji_lampuutamapenyimpanganlampukanan','$alatuji_lampuutamapenyimpanganlampukiri','$alatuji_penunjukkecepatan','$alatuji_kedalamanalurban','$masaberlakuuji','$tgluji','$statuslulusuji')";
            Yii::app()->db->createCommand($sql)->execute();
        } else {
            $sql = "UPDATE datapengujian SET 
            statuspenerbitan = '$statuspenerbitan',
            nouji = '$nouji',
            nama = '$nama',
            alamat = '$alamat',
            nosertifikatreg = '$nosertifikatreg',
            tglsertifikatreg = '$tglsertifikatreg',
            noregistrasikendaraan = '$noregistrasikendaraan',
            norangka = '$norangka',
            nomesin = '$nomesin',
            merek = '$merek',
            tipe = '$tipe',
            jenis = '$jenis',
            thpembuatan = '$thpembuatan',
            bahanbakar = '$bahanbakar',
            isisilinder = '$isisilinder',
            dayamotorpenggerak = '$dayamotorpenggerak',
            jbb = '$jbb',
            jbkb = '$jbkb',
            jbi = '$jbi',
            jbki = '$jbki',
            mst = '$mst',
            beratkosong = '$beratkosong',
            konfigurasisumburoda = '$konfigurasisumburoda',
            ukuranban = '$ukuranban',
            panjangkendaraan = '$panjangkendaraan',
            lebarkendaraan = '$lebarkendaraan',
            tinggikendaraan = '$tinggikendaraan',
            panjangbakatautangki = '$panjangbakatautangki',
            lebarbakatautangki = '$lebarbakatautangki',
            tinggibakatautangki = '$tinggibakatautangki',
            julurdepan = '$julurdepan',
            julurbelakang = '$julurbelakang',
            jaraksumbu1_2 = '$jaraksumbu1_2',
            jaraksumbu2_3 = '$jaraksumbu2_3',
            jaraksumbu3_4 = '$jaraksumbu3_4',
            dayaangkutorang = '$dayaangkutorang',
            dayaangkutbarang = '$dayaangkutbarang',
            kelasjalanterendah = '$kelasjalanterendah',
            idpetugasuji = '$idpetugasuji',
            idkepaladinas = '$idkepaladinas',
            iddirektur = '$iddirektur',
            kodewilayah = 'PMKSN',
            kodewilayahasal = '$kodewilayahasal',
            huv_nomordankondisirangka = 1,
            huv_nomordantipemotorpenggerak = 1,
            huv_kondisitangkicorongdanpipabahanbakar = 1,
            huv_kondisiconverterkit = 1,
            huv_kondisidanposisipipapembuangan = 1,
            huv_ukurandankondisiban = 1,
            huv_kondisisistemsuspensi = 1,
            huv_kondisisistemremutama = 1,
            huv_kondisipenutuplampudanalatpantulcahaya  = 1,
            huv_kondisipanelinstrumentdashboard = 1,
            huv_kondisikacaspion = 1,
            huv_kondisispakbor = 1,
            huv_bentukbumper = 1,
            huv_keberadaandankondisiperlengkapan = 1,
            huv_rancanganteknis = 1,
            huv_keberadaandankondisifasilitastanggapdaruratuntukmobilbus = 1,
            huv_kondisibadankacaengseltempatdudukmbarangbakmuatantertutup = 1,
            hum_kondisipenerusdaya = 1,
            hum_sudutbebaskemudi = 1,
            hum_kondisiremparkir = 1,
            hum_fungsilampudanalatpantulcahaya = 1,
            hum_fungsipenghapuskaca = 1,
            hum_tingkatkegelapankaca = 1,
            hum_fungsiklakson = 1,
            hum_kondisidanfungsisabukkeselamatan = 1,
            hum_ukurankendaraan = 1,
            hum_ukurantempatdudukdanbagiandalamkendaraanuntukmobilbus = 1,
            alatuji_emisiasapbahanbakarsolar = '$alatuji_emisiasapbahanbakarsolar',
            alatuji_emisicobahanbakarbensin = '$alatuji_emisicobahanbakarbensin',
            alatuji_emisihcbahanbakarbensin = '$alatuji_emisihcbahanbakarbensin',
            alatuji_remutamatotalgayapengereman = '$alatuji_remutamatotalgayapengereman',
            alatuji_remutamaselisihgayapengeremanrodakirikanan1 = '$alatuji_remutamaselisihgayapengeremanrodakirikanan1',
            alatuji_remutamaselisihgayapengeremanrodakirikanan2 = '$alatuji_remutamaselisihgayapengeremanrodakirikanan2',
            alatuji_remutamaselisihgayapengeremanrodakirikanan3 = '$alatuji_remutamaselisihgayapengeremanrodakirikanan3',
            alatuji_remutamaselisihgayapengeremanrodakirikanan4 = '$alatuji_remutamaselisihgayapengeremanrodakirikanan4',
            alatuji_remparkirtangan = '$alatuji_remparkirtangan',
            alatuji_remparkirkaki = '$alatuji_remparkirkaki',
            alatuji_kincuprodadepan = '$alatuji_kincuprodadepan',
            alatuji_tingkatkebisingan = '$alatuji_tingkatkebisingan',
            alatuji_lampuutamakekuatanpancarlampukanan = '$alatuji_lampuutamakekuatanpancarlampukanan',
            alatuji_lampuutamakekuatanpancarlampukiri = '$alatuji_lampuutamakekuatanpancarlampukiri',
            alatuji_lampuutamapenyimpanganlampukanan = '$alatuji_lampuutamapenyimpanganlampukanan',
            alatuji_lampuutamapenyimpanganlampukiri = '$alatuji_lampuutamapenyimpanganlampukiri',
            alatuji_penunjukkecepatan = '$alatuji_penunjukkecepatan',
            alatuji_kedalamanalurban = '$alatuji_kedalamanalurban',
            masaberlakuuji = '$masaberlakuuji',
            tgluji = '$tgluji',
            statuslulusuji = TRUE WHERE tgluji = '$tglUji' AND nouji = '$dtHasilUji->no_uji'";
            Yii::app()->db->createCommand($sql)->execute();
        }
    }

    public function actionCetakl($id, $posisi, $nrp)
    {
        $this->layout = '//';
        $this->render('cetak_l', array('id' => $id, 'nrp' => $nrp, 'posisi' => $posisi));
    }

    public function actionProsesBlokir()
    {
        $id_kedaraan = $_POST['id_kendaraan'];
        $blokir = $_POST['keterangan_blokir'];
        $dtKend = TblKendaraan::model()->findByAttributes(array('id_kendaraan' => $id_kedaraan));
        $nm_pemilik = $dtKend->nama_pemilik;
        $tanggal = date("m/d/Y");
        $update = "UPDATE tbl_kendaraan SET blokir='true', keterangan_blokir='$blokir', tgl_blokir='$tanggal' WHERE id_kendaraan = $id_kedaraan";
        Yii::app()->db->createCommand($update)->execute();
    }

    public function actionProsesUnBlokir()
    {
        $id_kendaraan = $_POST['id_kendaraan'];
        $dtKend = TblKendaraan::model()->findByAttributes(array('id_kendaraan' => $id_kendaraan));
        $update = "UPDATE tbl_kendaraan SET blokir='false', keterangan_blokir='', tgl_blokir=NULL WHERE id_kendaraan = $id_kendaraan";
        Yii::app()->db->createCommand($update)->execute();
    }

    public function actionViewImage()
    {
        $id_hasil_uji = $_POST['idHasilUji'];
        $data = TblHasilUji::model()->findByPk($id_hasil_uji);
        echo json_encode(
            array(
                'img_depan' => $data->img_depan,
                'img_belakang' => $data->img_belakang,
                'img_kanan' => $data->img_kanan,
                'img_kiri' => $data->img_kiri,
            )
        );
    }
}
