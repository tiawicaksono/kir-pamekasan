<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of terminal
 *
 * @author TIA.WICAKSONO
 */
class DefaultController extends Controller
{
    /* =====================================================================
     * BARCODE DALOPS
      ===================================================================== */

    public function actionRiwayatKendaraan()
    {
        $this->layout = '//';
        $no_uji = strtoupper($_POST['noUji']);
        $criteria = new CDbCriteria();
        $criteria->addCondition("(replace(LOWER(no_uji),' ','') like replace(LOWER('%" . $no_uji . "%'),' ','')) or (replace(LOWER(no_kendaraan),' ','') like replace(LOWER('%" . $no_uji . "%'),' ',''))");
        $criteria->order = 'id_riwayat DESC';
        $result = VRiwayat::model()->find($criteria);
        $tempat_uji = 'Pengujian Kendaraan Bermotor Wiyung, Surabaya';

        if (!empty($result)) {
            $data['tempat_uji'] = $tempat_uji;
            $data['no_uji'] = $result->no_uji;
            $data['no_kendaraan'] = $result->no_kendaraan;
            $data['mati_uji'] = date("d F Y", strtotime($result->tglmati));
            $data['merk'] = $result->merk;
            $data['tipe'] = $result->tipe;
            $data['no_chasis'] = $result->no_chasis;
            $data['no_mesin'] = $result->no_mesin;
            $data['pemilik'] = $result->nama_pemilik;
            if (strtotime($result->tglmati) < strtotime(date('m/d/Y'))) {
                $data['kondisi'] = 'mati';
            } else {
                $data['kondisi'] = 'hidup';
            }
            $data['success'] = true;
        } else {
            $data['tempat_uji'] = '-';
            $data['no_uji'] = '-';
            $data['no_kendaraan'] = '-';
            $data['mati_uji'] = '-';
            $data['merk'] = '-';
            $data['tipe'] = '-';
            $data['no_chasis'] = '-';
            $data['no_mesin'] = '-';
            $data['pemilik'] = '-';
            $data['kondisi'] = '-';
            $data['success'] = false;
        }
        echo json_encode($data);
    }

    public function actionDetailPersyaratan()
    {
        $this->layout = '//';
        $kategori = strtoupper($_POST['kategori']);
        //        $kategori = strtoupper('MUK');
        $criteria = new CDbCriteria();
        $criteria->addCondition("category_code = '$kategori'");
        $result = VPersyaratan::model()->findAll($criteria);
        $data = array();
        foreach ($result as $p) {
            $data[] = array(
                "keterangan" => $p->persyaratan,
            );
        }
        echo json_encode($data);
    }

    public function actionDetailKendaraan()
    {
        $this->layout = '//';
        $no_uji = strtoupper($_POST['noUji']);
        $criteria = new CDbCriteria();
        $criteria->addCondition("(replace(LOWER(no_uji),' ','') ilike replace(LOWER('%" . $no_uji . "%'),' ','')) or (replace(LOWER(no_kendaraan),' ','') ilike replace(LOWER('%" . $no_uji . "%'),' ','')) or (replace(LOWER(no_chasis),' ','') like replace(LOWER('%" . $no_uji . "%'),' ','')) or (replace(LOWER(no_mesin),' ','') like replace(LOWER('%" . $no_uji . "%'),' ',''))");
        $result = VKendaraan::model()->find($criteria);

        if (!empty($result)) {
            $dtRiwayat = VRiwayat::model()->find($criteria);
            $tgl_mati_uji = $dtRiwayat->tglmati;

            $criteriaHasilUji = new CDbCriteria();
            $criteriaHasilUji->addCondition("id_kendaraan = $result->id_kendaraan");
            $criteriaHasilUji->order = 'jdatang desc';
            $criteriaHasilUji->limit = 1;
            $hasilUji = TblHasilUji::model()->find($criteriaHasilUji);
            if (empty($hasilUji->img_depan)) {
                $img_depan = '-';
            } else {
                $img_depan = $hasilUji->img_depan;
            }

            if (empty($hasilUji->img_belakang)) {
                $img_belakang = '-';
            } else {
                $img_belakang = $hasilUji->img_belakang;
            }

            if (empty($hasilUji->img_kanan)) {
                $img_kanan = '-';
            } else {
                $img_kanan = $hasilUji->img_kanan;
            }

            if (empty($hasilUji->img_kiri)) {
                $img_kiri = '-';
            } else {
                $img_kiri = $hasilUji->img_kiri;
            }

            $data['id_kendaraan'] = $result->id_kendaraan;
            $data['no_uji'] = $result->no_uji;
            $data['no_kendaraan'] = $result->no_kendaraan;
            $data['merk'] = $result->merk;
            $data['tipe'] = $result->tipe;
            $data['no_chasis'] = $result->no_chasis;
            $data['no_mesin'] = $result->no_mesin;
            $data['pemilik'] = $result->nama_pemilik;
            $data['jns_kend'] = $result->karoseri_jenis;
            $data['mati_uji'] = date("d F Y", strtotime($tgl_mati_uji));
            $data['nama_komersil'] = $result->nm_komersil;
            $data['jenis_karoseri'] = $result->karoseri_jenis;
            $data['bahan_utama'] = $result->karoseri_bahan;
            $data['panjang'] = $result->ukuran_panjang . " mm";
            $data['lebar'] = $result->ukuran_lebar . " mm";
            $data['tinggi'] = $result->ukuran_tinggi . " mm";
            $data['dimpanjang'] = $result->dimpanjang . " mm";
            $data['dimlebar'] = $result->dimlebar . " mm";
            $data['dimtinggi'] = $result->dimtinggi . " mm";
            $data['jbb'] = $result->kemjbb . " Kg";
            $data['orang'] = $result->karoseri_duduk . " Orang, " . $result->kemorang . " Kg";
            $data['barang'] = $result->kembarang . " Kg";
            $bsumbu1 = $result->bsumbu1;
            $bsumbu2 = $result->bsumbu2;
            $bsumbu3 = $result->bsumbu3;
            $bsumbu4 = $result->bsumbu4;
            $bsumbu5 = $result->bsumbu5;
            $total_berat_sumbu = $bsumbu1 + $bsumbu2 + $bsumbu3 + $bsumbu4 + $bsumbu5;
            $data['sb1'] = $bsumbu1 . " Kg";
            $data['sb2'] = $bsumbu2 . " Kg";
            $data['sb3'] = $bsumbu3 . " Kg";
            $data['sb4'] = $bsumbu4 . " Kg";
            $data['sb5'] = $bsumbu5 . " Kg";
            $data['total_sb'] = $total_berat_sumbu . " Kg";
            $data['jbi'] = $result->jbi . " Kg";
            $data['mst'] = $result->mst . " Kg";
            if (strtotime($tgl_mati_uji) < strtotime(date('m/d/Y'))) {
                $data['kondisi'] = 'mati';
            } else {
                $data['kondisi'] = 'hidup';
            }
            $data['success'] = true;
            $data['tujuan'] = '-';
            $data['img_depan'] = $img_depan;
            $data['img_belakang'] = $img_belakang;
            $data['img_kanan'] = $img_kanan;
            $data['img_kiri'] = $img_kiri;
        } else {
            $data['id_kendaraan'] = '-';
            $data['no_uji'] = '-';
            $data['no_kendaraan'] = '-';
            $data['merk'] = '-';
            $data['tipe'] = '-';
            $data['no_chasis'] = '-';
            $data['no_mesin'] = '-';
            $data['pemilik'] = '-';
            $data['jns_kend'] = '-';
            $data['mati_uji'] = '-';
            $data['nama_komersil'] = '-';
            $data['jenis_karoseri'] = '-';
            $data['bahan_utama'] = '-';
            $data['panjang'] = '-';
            $data['lebar'] = '-';
            $data['tinggi'] = '-';
            $data['dimpanjang'] = '-';
            $data['dimlebar'] = '-';
            $data['dimtinggi'] = '-';
            $data['jbb'] = '-';
            $data['orang'] = '-';
            $data['barang'] = '-';
            $data['sb1'] = '-';
            $data['sb2'] = '-';
            $data['sb3'] = '-';
            $data['sb4'] = '-';
            $data['sb5'] = '-';
            $data['total_sb'] = '-';
            $data['jbi'] = '-';
            $data['mst'] = '-';
            $data['kondisi'] = 'mati';
            $data['success'] = false;
            $data['tujuan'] = '-';
            $data['img_depan'] = '-';
            $data['img_belakang'] = '-';
            $data['img_kanan'] = '-';
            $data['img_kiri'] = '-';
        }
        echo json_encode($data);
    }

    public function actionHasilUji()
    {
        $this->layout = '//';
        $no_uji = strtoupper($_POST['noUji']);
        $criteria = new CDbCriteria();
        $criteria->order = 'id_hasil_uji DESC';
        $criteria->addCondition("(replace(LOWER(no_uji),' ','') like replace(LOWER('%" . $no_uji . "%'),' ','')) or (replace(LOWER(no_kendaraan),' ','') like replace(LOWER('%" . $no_uji . "%'),' ',''))");
        $result = VStatusProsesAll::model()->find($criteria);
        if (!empty($result)) {
            // IMAGE
            if (empty($result->img_depan)) {
                $img_depan = '-';
            } else {
                $img_depan = $result->img_depan;
            }

            if (empty($result->img_belakang)) {
                $img_belakang = '-';
            } else {
                $img_belakang = $result->img_belakang;
            }

            if (empty($result->img_kanan)) {
                $img_kanan = '-';
            } else {
                $img_kanan = $result->img_kanan;
            }

            if (empty($result->img_kiri)) {
                $img_kiri = '-';
            } else {
                $img_kiri = $result->img_kiri;
            }
            //prauji
            if ($result->prauji == "true") {
                $prauji = 1;
                if ($result->lulus_prauji == "true")
                    $hasil_prauji = "LULUS";
                else
                    $hasil_prauji = "TIDAK LULUS";
            } else {
                $prauji = 0;
                $hasil_prauji = "PROSES";
            }
            //smoke
            if ($result->smoke == "true") {
                $smoke = 1;
                if ($result->lulus_smoke == "true")
                    $hasil_emisi = "LULUS";
                else
                    $hasil_emisi = "TIDAK LULUS";
            } else {
                $smoke = 0;
                $hasil_emisi = "PROSES";
            }
            //pitlift
            if ($result->pitlift == "true") {
                $pitlift = 1;
                if ($result->lulus_pitlift == "true")
                    $hasil_pitlift = "LULUS";
                else
                    $hasil_pitlift = "TIDAK LULUS";
            } else {
                $pitlift = 0;
                $hasil_pitlift = "PROSES";
            }
            //lampu
            if ($result->lampu == "true") {
                $lampu = 1;
                if ($result->lulus_lampu == "true")
                    $hasil_lampu = "LULUS";
                else
                    $hasil_lampu = "TIDAK LULUS";
            } else {
                $lampu = 0;
                $hasil_lampu = "PROSES";
            }
            //rem
            if ($result->break == "true") {
                $break = 1;
                if ($result->lulus_break == "true")
                    $hasil_break = "LULUS";
                else
                    $hasil_break = "TIDAK LULUS";
            } else {
                $break = 0;
                $hasil_break = "PROSES";
            }

            if ($prauji == 1 && $smoke == 1 && $pitlift == 1 && $lampu == 1 && $break == 1) {
                if ($result->hasil == "true")
                    $ltl = 'LULUS';
                else
                    $ltl = 'TIDAK LULUS';
            } else {
                $ltl = 'PROSES';
            }

            $dataTl = VDetailTl::model()->findAllByAttributes(array('id_hasil_uji' => $result->id_hasil_uji));
            $keterangan = '';
            $no = 1;
            if ($ltl == 'TIDAK LULUS') {
                foreach ($dataTl as $p) {
                    $keterangan .= $no . ". " . $p->kelulusan . "\n";
                    $no++;
                }
            }
            $data['no_uji'] = $result->no_uji;
            $data['no_kendaraan'] = $result->no_kendaraan;
            $data['pemilik'] = $result->nama_pemilik;
            $data['hasil_tgl_terakhir_uji'] = date("d F Y", strtotime($result->jdatang));
            $data['hasil_tgl_mati_uji'] = date("d F Y", strtotime($result->tgl_mati_uji));
            $data['hasil_prauji'] = $hasil_prauji;
            $data['hasil_emisi'] = $hasil_emisi;
            $data['hasil_pitlift'] = $hasil_pitlift;
            $data['hasil_lampu'] = $hasil_lampu;
            $data['hasil_break'] = $hasil_break;
            $data['ltl'] = $ltl;
            $data['keterangan'] = $keterangan;
            if (strtotime($result->tgl_mati_uji) < strtotime(date('m/d/Y'))) {
                $data['kondisi'] = 'mati';
            } else {
                $data['kondisi'] = 'hidup';
            }
            $data['img_depan'] = $img_depan;
            $data['img_belakang'] = $img_belakang;
            $data['img_kanan'] = $img_kanan;
            $data['img_kiri'] = $img_kiri;
        } else {
            $data['no_uji'] = '-';
            $data['no_kendaraan'] = "-";
            $data['pemilik'] = "-";
            $data['hasil_tgl_terakhir_uji'] = "-";
            $data['hasil_tgl_mati_uji'] = "-";
            $data['hasil_prauji'] = "-";
            $data['hasil_emisi'] = "-";
            $data['hasil_pitlift'] = "-";
            $data['hasil_lampu'] = "-";
            $data['hasil_break'] = "-";
            $data['ltl'] = "-";
            $data['keterangan'] = "-";
            $data['kondisi'] = 'mati';
            $data['img_depan'] = 'A';
            $data['img_belakang'] = '-';
            $data['img_kanan'] = '-';
            $data['img_kiri'] = '-';
        }
        echo json_encode($data);
    }

    public function actionStatusRekom()
    {
        $this->layout = '//';
        $no_uji = strtoupper($_POST['noUji']);
        $criteria = new CDbCriteria();
        $criteria->addCondition("(replace(LOWER(no_uji),' ','') like replace(LOWER('%" . $no_uji . "%'),' ','')) or (replace(LOWER(no_kendaraan),' ','') like replace(LOWER('%" . $no_uji . "%'),' ',''))");
        $result = VRekomAndroid::model()->find($criteria);
        if (!empty($result)) {
            $data['no_uji'] = $result->no_uji;
            $data['no_kendaraan'] = $result->no_kendaraan;
            $data['tgl_rekom'] = date("d F Y", strtotime($result->tgl_retribusi));
            if ($result->mutke == true) {
                $rekom = "Mutasi Keluar";
            } elseif ($result->numke == true) {
                $rekom = "Numpang Keluar";
            } elseif ($result->ubhsifat == true) {
                $rekom = "Ubah Sifat";
            } else {
                $rekom = "-";
            }
            $data['rekom'] = $rekom;

            $criteriaRekomStatus = new CDbCriteria();
            $criteriaRekomStatus->addInCondition('id_rekom', array($result->id_rekom));
            $dataCriteriaRekomStatus = TblRekomStatus::model()->find($criteriaRekomStatus);
            if (empty($dataCriteriaRekomStatus)) {
                $kasubag = 0;
                $kaupt = 0;
                $kadis = 0;
                $tglKasubag = '-';
                $tglKaupt = '-';
                $tglKadis = '-';
            } else {
                $kasubag = $dataCriteriaRekomStatus->approve1;
                $kaupt = $dataCriteriaRekomStatus->approve2;
                $kadis = $dataCriteriaRekomStatus->approve3;
                $tglKasubag = date("d F Y", strtotime($dataCriteriaRekomStatus->tgl_approve1));
                $tglKaupt = date("d F Y", strtotime($dataCriteriaRekomStatus->tgl_approve2));
                $tglKadis = date("d F Y", strtotime($dataCriteriaRekomStatus->tgl_approve3));
            }
            $data['kasubag'] = $kasubag;
            $data['kaupt'] = $kaupt;
            $data['kadis'] = $kadis;
            $data['tglKasubag'] = $tglKasubag;
            $data['tglKaupt'] = $tglKaupt;
            $data['tglKadis'] = $tglKadis;
            $data['lokasiRekom'] = "UPTD PKB Wiyung Surabaya";
        } else {
            $data['no_uji'] = '-';
            $data['no_kendaraan'] = '-';
            $data['tgl_rekom'] = '-';
            $data['rekom'] = '-';
            $data['kasubag'] = 0;
            $data['kaupt'] = 0;
            $data['kadis'] = 0;
            $data['tglKasubag'] = '-';
            $data['tglKaupt'] = '-';
            $data['tglKadis'] = '-';
            $data['lokasiRekom'] = "UPTD PKB Wiyung Tandes";
        }

        echo json_encode($data);
    }

    public function actionListKendaraan()
    {
        $tanggal = date("Y-m-d");
        $no_uji = strtoupper($_POST['noUji']);
        //        $tanggal = "2017-07-05";
        $per_page = 7;
        $page = (isset($_POST['index'])) ? (int) $_POST['index'] : 0;
        $start = ($page) * $per_page;
        $criteriaWiyung = new CDbCriteria();
        $criteriaWiyung->order = "id_hasil_uji DESC";
        $criteriaWiyung->limit = $per_page;
        $criteriaWiyung->offset = $start;
        if (!empty($no_uji)) {
            $criteriaWiyung->addCondition("(replace(LOWER(no_uji),' ','') like replace(LOWER('%" . $no_uji . "%'),' ','')) or (replace(LOWER(no_kendaraan),' ','') like replace(LOWER('%" . $no_uji . "%'),' ',''))");
        }
        $result = VVerifikasi::model()->findAll($criteriaWiyung);
        $response = array();
        if (!empty($result)) {
            foreach ($result as $row) {
                $response[] = array(
                    'no_kendaraan' => $row->no_kendaraan,
                    'no_uji' => $row->no_uji,
                    'nama_pemilik' => $row->nama_pemilik,
                    'status_kelulusan' => $row->hasil == 'true' ? 'LULUS' : 'TIDAK LULUS'
                );
            }
        }
        echo json_encode($response);
    }

    public function actionTotalListKendaraan()
    {
        $sql_tandes = "select 
        (select jml_kuota from tbl_kuota) as total,
        (select count(*) from tbl_daftar where tgl_uji=current_date) as jml,
        (select count(*) from tbl_daftar where tgl_uji=current_date and id_jns=0) as brg,
        (select count(*) from tbl_daftar where tgl_uji=current_date and datang='true') as dtg,
        (select count(*) from tbl_daftar where tgl_uji=current_date and datang='false') as td,
        (select count(*) from tbl_daftar where tgl_uji=current_date and datang='true' and lulus='true') as lls,
        (select count(*) from tbl_daftar a left join tbl_hasil_uji b ON a.id_daftar=b.id_daftar where a.tgl_uji=current_date and a.datang='true' and a.lulus='false' and b.cetak='true') as tdklls,
        (select count(*) from tbl_daftar where tgl_uji=current_date and datang='true')-((select count(*) from tbl_daftar where tgl_uji=current_date and datang='true' and lulus='true') + (select count(*) from tbl_daftar a left join tbl_hasil_uji b ON a.id_daftar=b.id_daftar where a.tgl_uji=current_date and a.datang='true' and a.lulus='false' and b.cetak='true')) as blmprs,
        (select count(*) from tbl_daftar where tgl_uji=current_date and id_jns=1) as pnp,
        (select count(*) from tbl_daftar where tgl_uji=current_date and id_jns=2) as bis,
        (select count(*) from tbl_daftar where tgl_uji=current_date and id_jns=3) as khs,
        (select count(*) from tbl_daftar where tgl_uji=current_date and id_jns=4) as gdn,
        (select count(*) from tbl_daftar where tgl_uji=current_date and id_jns=5) as tmp,
        (select jml_kuota from tbl_kuota)-(select count(*) from tbl_daftar where tgl_uji=current_date) as sisa";
        $row_tandes = Yii::app()->db->createCommand($sql_tandes)->queryRow();

        $data['mobil_barang_tandes'] = $row_tandes['brg'];
        $data['mobil_bis_tandes'] = $row_tandes['bis'];
        $data['mobil_penumpang_tandes'] = $row_tandes['pnp'];
        $data['mobil_khusus_tandes'] = $row_tandes['khs'];
        $data['mobil_gandengan_tandes'] = $row_tandes['gdn'];
        $data['mobil_tempelan_tandes'] = $row_tandes['tmp'];
        $data['jumlah_tandes'] = $row_tandes['jml'];
        $data['mobil_datang_tandes'] = $row_tandes['dtg'];
        $data['mobil_tidak_datang_tandes'] = $row_tandes['td'];
        $data['lulus_uji_tandes'] = $row_tandes['lls'];
        $data['tidak_lulus_uji_tandes'] = $row_tandes['tdklls'];
        echo json_encode($data);
    }

    public function actionListRiwayatKendaraan()
    {
        $this->layout = '//';
        $no_uji = strtoupper($_POST['noUji']);
        $criteria = new CDbCriteria();
        $criteria->order = 'id_riwayat DESC';
        $criteria->addCondition("(replace(LOWER(no_uji),' ','') like replace(LOWER('%" . $no_uji . "%'),' ','')) or (replace(LOWER(no_kendaraan),' ','') like replace(LOWER('%" . $no_uji . "%'),' ',''))");
        $result = VRiwayat::model()->findAll($criteria);
        $data = array();
        if (!empty($result)) {
            foreach ($result as $p) {
                $nm_uji = 'BERKALA';
                $catatan = '-';
                if ($p->jenis_uji == 'MK') {
                    $nm_uji = 'MUTASI KELUAR';
                    $catatan = strtoupper($p->catatan);
                } else if ($p->jenis_uji == 'NK') {
                    $nm_uji = 'NUMPANG UJI KELUAR';
                    $catatan = strtoupper($p->catatan);
                }
                $data[] = array(
                    "no_uji" => $p->no_uji,
                    "no_kendaraan" => $p->no_kendaraan,
                    "tgl_uji" => date("d F Y", strtotime($p->tgl_uji)),
                    "tglmati" => date("d F Y", strtotime($p->tglmati)),
                    "merk" => $p->merk,
                    "tipe" => $p->tipe,
                    "no_chasis" => $p->no_chasis,
                    "no_mesin" => $p->no_mesin,
                    "nm_penguji" => empty($p->nama_penguji) ? ' -' : $p->nama_penguji,
                    "nrp" => empty($p->nrp) ? ' -' : $p->nrp,
                    "no_seri" => $p->no_seri,
                    "nm_uji" => $nm_uji,
                    "catatan" => $catatan
                );
            }
        }
        echo json_encode($data);
    }

    public function actionSaveRetribusi()
    {
        $idKendaraan = $_POST['idKendaraan'];
        $tgl_uji = DateTime::createFromFormat('d/m/Y', $_POST['tglUji']);
        $tglUji = $tgl_uji->format('m/d/Y');

        $criteria = new CDbCriteria();
        $criteria->addCondition("id_kendaraan = '$idKendaraan'");
        $criteria->addCondition("tgl_uji = '$tglUji'");
        $data = TblRetribusiTemp::model()->find($criteria);
        $result['va'] = '0';
        if (!empty($data)) {
            $result['cek'] = '1';
            $result['va'] = $data->va;
            $b_lulus_uji = $data->b_lulus_uji;
            $b_admin = $data->b_admin;
            $b_tlt_daftar = $data->b_tlt_daftar;
            $b_tlt_uji = $data->b_tlt_uji;
            $b_plat_uji = $data->b_plat_uji;
            $b_tanda_samping = $data->b_tanda_samping;
            $total = $b_lulus_uji + $b_admin + $b_tlt_daftar + $b_tlt_uji + $b_plat_uji + $b_tanda_samping;
            $result['b_lulus_uji'] = "Rp. " . number_format($b_lulus_uji, 0, ',', '.') . ",-";
            $result['b_admin'] = "Rp. " . number_format($b_admin, 0, ',', '.') . ",-";
            $result['b_tlt_daftar'] = "Rp. " . number_format($b_tlt_daftar, 0, ',', '.') . ",-";
            $result['b_tlt_uji'] = "Rp. " . number_format($b_tlt_uji, 0, ',', '.') . ",-";
            $result['b_plat_uji'] = "Rp. " . number_format($b_plat_uji, 0, ',', '.') . ",-";
            $result['b_tanda_samping'] = "Rp. " . number_format($b_tanda_samping, 0, ',', '.') . ",-";
            $result['total_bayar'] = "Rp. " . number_format($total, 0, ',', '.') . ",-";
        } else {
            $result['cek'] = '0';
            $new = new TblRetribusiTemp();
            $new->id_kendaraan = $idKendaraan;
            $new->tgl_uji = $tglUji;
            $new->va = 234567;
            $new->b_lulus_uji = '18000';
            $new->b_admin = '3000';
            $new->b_tlt_daftar = '1500';
            $new->b_tlt_uji = '10000';
            $new->b_plat_uji = '6000';
            $new->b_tanda_samping = '15000';
            $new->save();
            //            $insert = "INSERT INTO tbl_retribusi_temp(id_kendaraan,tgl_uji) VALUES ($idKendaraan,'$tglUji')";
            //            Yii::app()->db->createCommand($insert)->execute();
            $criteria = new CDbCriteria();
            $criteria->addCondition("id_kendaraan = '$idKendaraan'");
            $criteria->addCondition("tgl_uji = '$tglUji'");
            $data = TblRetribusiTemp::model()->find($criteria);
            $result['va'] = $data->va;
            $b_lulus_uji = $data->b_lulus_uji;
            $b_admin = $data->b_admin;
            $b_tlt_daftar = $data->b_tlt_daftar;
            $b_tlt_uji = $data->b_tlt_uji;
            $b_plat_uji = $data->b_plat_uji;
            $b_tanda_samping = $data->b_tanda_samping;
            $total = $b_lulus_uji + $b_admin + $b_tlt_daftar + $b_tlt_uji + $b_plat_uji + $b_tanda_samping;
            $result['b_lulus_uji'] = "Rp. " . number_format($b_lulus_uji, 0, ',', '.') . ",-";
            $result['b_admin'] = "Rp. " . number_format($b_admin, 0, ',', '.') . ",-";
            $result['b_tlt_daftar'] = "Rp. " . number_format($b_tlt_daftar, 0, ',', '.') . ",-";
            $result['b_tlt_uji'] = "Rp. " . number_format($b_tlt_uji, 0, ',', '.') . ",-";
            $result['b_plat_uji'] = "Rp. " . number_format($b_plat_uji, 0, ',', '.') . ",-";
            $result['b_tanda_samping'] = "Rp. " . number_format($b_tanda_samping, 0, ',', '.') . ",-";
            $result['total_bayar'] = "Rp. " . number_format($total, 0, ',', '.') . ",-";
        }
        echo json_encode($result);
    }

    public function actionProvinsi()
    {
        $criteria = new CDbCriteria();
        $criteria->limit = 1000;
        $criteria->offset = 11000;
        $dataKendaraan = VKendaraanProvinsi::model()->findAll($criteria);

        $url = "http://basdap.dishub.jatimprov.go.id/api/getkendaraan";
        $key = "T1dRd05USTVPV1F3WkdFMk1tSXpOelJqWWpGbE9HRmlOamMzWVdSbFl6TT0=";
        $id_pkb = "183";
        foreach ($dataKendaraan as $kendaraan) {
            $data = array(
                'key' => $key,
                'id_pkb' => $id_pkb,
                'no_kendaraan' => empty($kendaraan->no_kendaraan) ? '-' : $kendaraan->no_kendaraan,
                'nama_pemilik' => empty($kendaraan->nama_pemilik) ? '-' : $kendaraan->nama_pemilik,
                'alamat_pemilik' => empty($kendaraan->telpon_pemilik) ? '-' : $kendaraan->alamat_pemilik,
                'email_pemilik' => $kendaraan->email_pemilik,
                'telpon_pemilik' => empty($kendaraan->telpon_pemilik) ? '0' : $kendaraan->telpon_pemilik,
                'ktp_pemilik' => empty($kendaraan->ktp_pemilik) ? '-' : $kendaraan->ktp_pemilik,
                'no_rangka' => empty($kendaraan->no_rangka) ? '-' : $kendaraan->no_rangka,
                'no_mesin' => empty($kendaraan->no_mesin) ? '-' : $kendaraan->no_mesin,
                'no_uji' => empty($kendaraan->no_uji) ? '-' : $kendaraan->no_uji,
                'berlaku_uji' => empty($kendaraan->berlaku_uji) ? date('Y-m-d') : $kendaraan->berlaku_uji,
                'tahun_kendaraan' => empty($kendaraan->tahun_kendaraan) ? '0' : $kendaraan->tahun_kendaraan,
                'merek_kendaraan' => empty($kendaraan->merek_kendaraan) ? '-' : $kendaraan->merek_kendaraan,
                'tipe_kendaraan' => empty($kendaraan->tipe_kendaraan) ? '-' : $kendaraan->tipe_kendaraan,
                'id_jenis_kendaraan' => empty($kendaraan->id_jenis_kendaraan) ? date('Y-m-d') : $kendaraan->id_jenis_kendaraan,
                'id_sub_jenis_kendaraan' => empty($kendaraan->id_sub_jenis_kendaraan) ? '0' : $kendaraan->id_sub_jenis_kendaraan,
                'tahun_buat' => $kendaraan->tahun_buat,
                'cc' => empty($kendaraan->cc) ? '0' : $kendaraan->cc,
                'daya_motor' => empty($kendaraan->daya_motor) ? '0' : $kendaraan->daya_motor,
                'no_srut' => empty($kendaraan->no_srut) ? '-' : $kendaraan->no_srut,
                'tanggal_srut' => empty($kendaraan->tanggal_srut) ? date('Y-m-d') : $kendaraan->tanggal_srut,
                'konfigurasi_sumbu' => empty($kendaraan->konfigurasi_sumbu) ? '0' : $kendaraan->konfigurasi_sumbu,
                'jbb' => empty($kendaraan->jbb) ? '0' : $kendaraan->jbb,
                'daya_angkut_barang' => empty($kendaraan->daya_angkut_barang) ? '0' : $kendaraan->daya_angkut_barang,
                'daya_angkut_penumpang' => empty($kendaraan->daya_angkut_penumpang) ? '0' : $kendaraan->daya_angkut_penumpang,
                'jbi' => $kendaraan->jbi,
                'mst' => empty($kendaraan->mst) ? '0' : $kendaraan->mst,
                'panjang_k' => empty($kendaraan->panjang_k) ? '0' : $kendaraan->panjang_k,
                'lebar_k' => empty($kendaraan->lebar_k) ? '0' : $kendaraan->lebar_k,
                'tinggi_k' => empty($kendaraan->tinggi_k) ? '0' : $kendaraan->tinggi_k,
                'julur_belakang' => empty($kendaraan->julur_belakang) ? '0' : $kendaraan->julur_belakang,
                'julur_depan' => empty($kendaraan->julur_depan) ? '0' : $kendaraan->julur_depan,
                'q' => empty($kendaraan->q) ? '0' : $kendaraan->q,
                'p' => empty($kendaraan->p) ? '0' : $kendaraan->p,
                'a' => empty($kendaraan->a) ? '0' : $kendaraan->a,
                'b' => empty($kendaraan->b) ? '0' : $kendaraan->b,
                'sumbu12' => empty($kendaraan->sumbu12) ? '0' : $kendaraan->sumbu12,
                'sumbu23' => empty($kendaraan->sumbu23) ? '0' : $kendaraan->sumbu23,
                'sumbu34' => empty($kendaraan->sumbu34) ? '0' : $kendaraan->sumbu34,
                'panjang_b' => empty($kendaraan->panjang_b) ? '0' : $kendaraan->panjang_b,
                'lebar_b' => empty($kendaraan->lebar_b) ? '0' : $kendaraan->lebar_b,
                'tinggi_b' => empty($kendaraan->tinggi_b) ? '0' : $kendaraan->tinggi_b,
                'bahan_b' => empty($kendaraan->bahan_b) ? '0' : $kendaraan->bahan_b,
                'panjang_t' => empty($kendaraan->panjang_t) ? '0' : $kendaraan->panjang_t,
                'lebar_t' => empty($kendaraan->lebar_t) ? '0' : $kendaraan->lebar_t,
                'tinggi_t' => empty($kendaraan->tinggi_t) ? '0' : $kendaraan->tinggi_t,
                'volume_t' => empty($kendaraan->volume_t) ? '0' : $kendaraan->volume_t,
                'bahan_t' => empty($kendaraan->bahan_t) ? '0' : $kendaraan->bahan_t,
                'berat_kosong_s1' => empty($kendaraan->berat_kosong_s1) ? '0' : $kendaraan->berat_kosong_s1,
                'berat_kosong_s2' => empty($kendaraan->berat_kosong_s2) ? '0' : $kendaraan->berat_kosong_s2,
                'berat_kosong_s3' => empty($kendaraan->berat_kosong_s3) ? '0' : $kendaraan->berat_kosong_s3,
                'berat_kosong_s4' => empty($kendaraan->berat_kosong_s4) ? '0' : $kendaraan->berat_kosong_s4,
                'berat_kosong' => empty($kendaraan->berat_kosong) ? '0' : $kendaraan->berat_kosong,
                'd_orang' => empty($kendaraan->d_orang) ? '0' : $kendaraan->d_orang,
                'eq_orang' => empty($kendaraan->eq_orang) ? '0' : $kendaraan->eq_orang,
                'd_barang' => empty($kendaraan->d_barang) ? '0' : $kendaraan->d_barang,
                'jbki' => empty($kendaraan->jbki) ? '0' : $kendaraan->jbki,
                'kelas_jalan' => empty($kendaraan->kelas_jalan) ? '-' : $kendaraan->kelas_jalan,
                'bahan_bakar' => empty($kendaraan->bahan_bakar) ? '-' : $kendaraan->bahan_bakar,
                'warna_kendaraan' => empty($kendaraan->warna_kendaraan) ? '0' : $kendaraan->warna_kendaraan,
                'bentuk' => $kendaraan->bentuk
            );
            $postdata = json_encode($data);
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            $result = curl_exec($ch);
            curl_close($ch);
            print_r($result);
        }
    }
}
