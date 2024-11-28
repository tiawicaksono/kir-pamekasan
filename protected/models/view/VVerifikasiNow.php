<?php

/**
 * This is the model class for table "v_verifikasi_now".
 *
 * The followings are the available columns in table 'v_verifikasi_now':
 * @property string $no_antrian
 * @property string $stts_no
 * @property string $id_hasil_uji
 * @property string $id_daftar
 * @property boolean $prauji
 * @property boolean $cetak
 * @property string $no_kendaraan
 * @property string $no_uji
 * @property string $nama_pemilik
 * @property string $keterangan
 * @property string $merk
 * @property string $tahun
 * @property string $tipe
 * @property integer $antri
 * @property string $karoseri_jenis
 * @property string $bahan_bakar
 * @property string $nm_komersil
 * @property string $karoseri_bahan
 * @property string $ptgs_prauji
 * @property string $ptgs_smoke
 * @property string $ptgs_pitlift
 * @property string $ptgs_lampu
 * @property string $ptgs_break
 * @property boolean $lulus_prauji
 * @property boolean $lulus_smoke
 * @property boolean $lulus_pitlift
 * @property boolean $lulus_lampu
 * @property boolean $lulus_break
 * @property boolean $hasil
 * @property string $posisi
 * @property boolean $smoke
 * @property boolean $pitlift
 * @property boolean $lampu
 * @property boolean $break
 */
class VVerifikasiNow extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'v_verifikasi_now';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('antri', 'numerical', 'integerOnly'=>true),
			array('no_kendaraan, no_uji, merk, tahun, tipe, karoseri_jenis, bahan_bakar, karoseri_bahan, ptgs_prauji, ptgs_smoke, ptgs_pitlift, ptgs_lampu, ptgs_break', 'length', 'max'=>30),
			array('nama_pemilik, nm_komersil', 'length', 'max'=>100),
			array('keterangan', 'length', 'max'=>1000),
			array('posisi', 'length', 'max'=>20),
			array('no_antrian, stts_no, id_hasil_uji, id_daftar, prauji, cetak, lulus_prauji, lulus_smoke, lulus_pitlift, lulus_lampu, lulus_break, hasil, smoke, pitlift, lampu, break', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('no_antrian, stts_no, id_hasil_uji, id_daftar, prauji, cetak, no_kendaraan, no_uji, nama_pemilik, keterangan, merk, tahun, tipe, antri, karoseri_jenis, bahan_bakar, nm_komersil, karoseri_bahan, ptgs_prauji, ptgs_smoke, ptgs_pitlift, ptgs_lampu, ptgs_break, lulus_prauji, lulus_smoke, lulus_pitlift, lulus_lampu, lulus_break, hasil, posisi, smoke, pitlift, lampu, break', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'no_antrian' => 'No Antrian',
			'stts_no' => 'Stts No',
			'id_hasil_uji' => 'Id Hasil Uji',
			'id_daftar' => 'Id Daftar',
			'prauji' => 'Prauji',
			'cetak' => 'Cetak',
			'no_kendaraan' => 'No Kendaraan',
			'no_uji' => 'No Uji',
			'nama_pemilik' => 'Nama Pemilik',
			'keterangan' => 'Keterangan',
			'merk' => 'Merk',
			'tahun' => 'Tahun',
			'tipe' => 'Tipe',
			'antri' => 'Antri',
			'karoseri_jenis' => 'Karoseri Jenis',
			'bahan_bakar' => 'Bahan Bakar',
			'nm_komersil' => 'Nm Komersil',
			'karoseri_bahan' => 'Karoseri Bahan',
			'ptgs_prauji' => 'Ptgs Prauji',
			'ptgs_smoke' => 'Ptgs Smoke',
			'ptgs_pitlift' => 'Ptgs Pitlift',
			'ptgs_lampu' => 'Ptgs Lampu',
			'ptgs_break' => 'Ptgs Break',
			'lulus_prauji' => 'Lulus Prauji',
			'lulus_smoke' => 'Lulus Smoke',
			'lulus_pitlift' => 'Lulus Pitlift',
			'lulus_lampu' => 'Lulus Lampu',
			'lulus_break' => 'Lulus Break',
			'hasil' => 'Hasil',
			'posisi' => 'Posisi',
			'smoke' => 'Smoke',
			'pitlift' => 'Pitlift',
			'lampu' => 'Lampu',
			'break' => 'Break',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('no_antrian',$this->no_antrian,true);
		$criteria->compare('stts_no',$this->stts_no,true);
		$criteria->compare('id_hasil_uji',$this->id_hasil_uji,true);
		$criteria->compare('id_daftar',$this->id_daftar,true);
		$criteria->compare('prauji',$this->prauji);
		$criteria->compare('cetak',$this->cetak);
		$criteria->compare('no_kendaraan',$this->no_kendaraan,true);
		$criteria->compare('no_uji',$this->no_uji,true);
		$criteria->compare('nama_pemilik',$this->nama_pemilik,true);
		$criteria->compare('keterangan',$this->keterangan,true);
		$criteria->compare('merk',$this->merk,true);
		$criteria->compare('tahun',$this->tahun,true);
		$criteria->compare('tipe',$this->tipe,true);
		$criteria->compare('antri',$this->antri);
		$criteria->compare('karoseri_jenis',$this->karoseri_jenis,true);
		$criteria->compare('bahan_bakar',$this->bahan_bakar,true);
		$criteria->compare('nm_komersil',$this->nm_komersil,true);
		$criteria->compare('karoseri_bahan',$this->karoseri_bahan,true);
		$criteria->compare('ptgs_prauji',$this->ptgs_prauji,true);
		$criteria->compare('ptgs_smoke',$this->ptgs_smoke,true);
		$criteria->compare('ptgs_pitlift',$this->ptgs_pitlift,true);
		$criteria->compare('ptgs_lampu',$this->ptgs_lampu,true);
		$criteria->compare('ptgs_break',$this->ptgs_break,true);
		$criteria->compare('lulus_prauji',$this->lulus_prauji);
		$criteria->compare('lulus_smoke',$this->lulus_smoke);
		$criteria->compare('lulus_pitlift',$this->lulus_pitlift);
		$criteria->compare('lulus_lampu',$this->lulus_lampu);
		$criteria->compare('lulus_break',$this->lulus_break);
		$criteria->compare('hasil',$this->hasil);
		$criteria->compare('posisi',$this->posisi,true);
		$criteria->compare('smoke',$this->smoke);
		$criteria->compare('pitlift',$this->pitlift);
		$criteria->compare('lampu',$this->lampu);
		$criteria->compare('break',$this->break);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VVerifikasiNow the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
