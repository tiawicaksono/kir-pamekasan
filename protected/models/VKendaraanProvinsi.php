<?php

/**
 * This is the model class for table "v_kendaraan_provinsi".
 *
 * The followings are the available columns in table 'v_kendaraan_provinsi':
 * @property string $no_kendaraan
 * @property string $nama_pemilik
 * @property string $alamat_pemilik
 * @property string $email_pemilik
 * @property string $telpon_pemilik
 * @property string $ktp_pemilik
 * @property string $no_rangka
 * @property string $no_mesin
 * @property string $no_uji
 * @property string $berlaku_uji
 * @property string $tahun_kendaraan
 * @property string $merek_kendaraan
 * @property string $tipe_kendaraan
 * @property string $id_jenis_kendaraan
 * @property string $id_sub_jenis_kendaraan
 * @property string $tahun_buat
 * @property string $cc
 * @property string $daya_motor
 * @property string $no_srut
 * @property string $tanggal_srut
 * @property string $konfigurasi_sumbu
 * @property string $jbb
 * @property string $daya_angkut_barang
 * @property string $daya_angkut_penumpang
 * @property double $jbi
 * @property double $mst
 * @property string $panjang_k
 * @property string $lebar_k
 * @property string $tinggi_k
 * @property string $julur_belakang
 * @property string $julur_depan
 * @property string $q
 * @property string $p
 * @property string $a
 * @property integer $b
 * @property string $sumbu12
 * @property string $sumbu23
 * @property string $sumbu34
 * @property string $panjang_b
 * @property string $lebar_b
 * @property string $tinggi_b
 * @property string $bahan_b
 * @property integer $panjang_t
 * @property integer $lebar_t
 * @property integer $tinggi_t
 * @property integer $volume_t
 * @property string $bahan_t
 * @property string $berat_kosong_s1
 * @property string $berat_kosong_s2
 * @property string $berat_kosong_s3
 * @property string $berat_kosong_s4
 * @property double $berat_kosong
 * @property string $d_orang
 * @property string $eq_orang
 * @property string $d_barang
 * @property string $jbki
 * @property string $kelas_jalan
 * @property string $bahan_bakar
 * @property string $warna_kendaraan
 * @property string $bentuk
 */
class VKendaraanProvinsi extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'v_kendaraan_provinsi';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('b, panjang_t, lebar_t, tinggi_t, volume_t', 'numerical', 'integerOnly'=>true),
			array('jbi, mst, berat_kosong', 'numerical'),
			array('telpon_pemilik', 'length', 'max'=>300),
			array('no_uji, cc, daya_motor, jbb, daya_angkut_barang, daya_angkut_penumpang, panjang_k, lebar_k, tinggi_k, julur_belakang, julur_depan, q, p, a, sumbu12, sumbu23, sumbu34, panjang_b, lebar_b, tinggi_b, bahan_b, berat_kosong_s1, berat_kosong_s2, berat_kosong_s3, berat_kosong_s4, d_orang, eq_orang, d_barang, jbki, kelas_jalan, bahan_bakar, warna_kendaraan', 'length', 'max'=>30),
			array('id_jenis_kendaraan, id_sub_jenis_kendaraan', 'length', 'max'=>100),
			array('no_srut', 'length', 'max'=>200),
			array('konfigurasi_sumbu', 'length', 'max'=>12),
			array('no_kendaraan, nama_pemilik, alamat_pemilik, email_pemilik, ktp_pemilik, no_rangka, no_mesin, berlaku_uji, tahun_kendaraan, merek_kendaraan, tipe_kendaraan, tahun_buat, tanggal_srut, bahan_t, bentuk', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('no_kendaraan, nama_pemilik, alamat_pemilik, email_pemilik, telpon_pemilik, ktp_pemilik, no_rangka, no_mesin, no_uji, berlaku_uji, tahun_kendaraan, merek_kendaraan, tipe_kendaraan, id_jenis_kendaraan, id_sub_jenis_kendaraan, tahun_buat, cc, daya_motor, no_srut, tanggal_srut, konfigurasi_sumbu, jbb, daya_angkut_barang, daya_angkut_penumpang, jbi, mst, panjang_k, lebar_k, tinggi_k, julur_belakang, julur_depan, q, p, a, b, sumbu12, sumbu23, sumbu34, panjang_b, lebar_b, tinggi_b, bahan_b, panjang_t, lebar_t, tinggi_t, volume_t, bahan_t, berat_kosong_s1, berat_kosong_s2, berat_kosong_s3, berat_kosong_s4, berat_kosong, d_orang, eq_orang, d_barang, jbki, kelas_jalan, bahan_bakar, warna_kendaraan, bentuk', 'safe', 'on'=>'search'),
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
			'no_kendaraan' => 'No Kendaraan',
			'nama_pemilik' => 'Nama Pemilik',
			'alamat_pemilik' => 'Alamat Pemilik',
			'email_pemilik' => 'Email Pemilik',
			'telpon_pemilik' => 'Telpon Pemilik',
			'ktp_pemilik' => 'Ktp Pemilik',
			'no_rangka' => 'No Rangka',
			'no_mesin' => 'No Mesin',
			'no_uji' => 'No Uji',
			'berlaku_uji' => 'Berlaku Uji',
			'tahun_kendaraan' => 'Tahun Kendaraan',
			'merek_kendaraan' => 'Merek Kendaraan',
			'tipe_kendaraan' => 'Tipe Kendaraan',
			'id_jenis_kendaraan' => 'Id Jenis Kendaraan',
			'id_sub_jenis_kendaraan' => 'Id Sub Jenis Kendaraan',
			'tahun_buat' => 'Tahun Buat',
			'cc' => 'Cc',
			'daya_motor' => 'Daya Motor',
			'no_srut' => 'No Srut',
			'tanggal_srut' => 'Tanggal Srut',
			'konfigurasi_sumbu' => 'Konfigurasi Sumbu',
			'jbb' => 'Jbb',
			'daya_angkut_barang' => 'Daya Angkut Barang',
			'daya_angkut_penumpang' => 'Daya Angkut Penumpang',
			'jbi' => 'Jbi',
			'mst' => 'Mst',
			'panjang_k' => 'Panjang K',
			'lebar_k' => 'Lebar K',
			'tinggi_k' => 'Tinggi K',
			'julur_belakang' => 'Julur Belakang',
			'julur_depan' => 'Julur Depan',
			'q' => 'Q',
			'p' => 'P',
			'a' => 'A',
			'b' => 'B',
			'sumbu12' => 'Sumbu12',
			'sumbu23' => 'Sumbu23',
			'sumbu34' => 'Sumbu34',
			'panjang_b' => 'Panjang B',
			'lebar_b' => 'Lebar B',
			'tinggi_b' => 'Tinggi B',
			'bahan_b' => 'Bahan B',
			'panjang_t' => 'Panjang T',
			'lebar_t' => 'Lebar T',
			'tinggi_t' => 'Tinggi T',
			'volume_t' => 'Volume T',
			'bahan_t' => 'Bahan T',
			'berat_kosong_s1' => 'Berat Kosong S1',
			'berat_kosong_s2' => 'Berat Kosong S2',
			'berat_kosong_s3' => 'Berat Kosong S3',
			'berat_kosong_s4' => 'Berat Kosong S4',
			'berat_kosong' => 'Berat Kosong',
			'd_orang' => 'D Orang',
			'eq_orang' => 'Eq Orang',
			'd_barang' => 'D Barang',
			'jbki' => 'Jbki',
			'kelas_jalan' => 'Kelas Jalan',
			'bahan_bakar' => 'Bahan Bakar',
			'warna_kendaraan' => 'Warna Kendaraan',
			'bentuk' => 'Bentuk',
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

		$criteria->compare('no_kendaraan',$this->no_kendaraan,true);
		$criteria->compare('nama_pemilik',$this->nama_pemilik,true);
		$criteria->compare('alamat_pemilik',$this->alamat_pemilik,true);
		$criteria->compare('email_pemilik',$this->email_pemilik,true);
		$criteria->compare('telpon_pemilik',$this->telpon_pemilik,true);
		$criteria->compare('ktp_pemilik',$this->ktp_pemilik,true);
		$criteria->compare('no_rangka',$this->no_rangka,true);
		$criteria->compare('no_mesin',$this->no_mesin,true);
		$criteria->compare('no_uji',$this->no_uji,true);
		$criteria->compare('berlaku_uji',$this->berlaku_uji,true);
		$criteria->compare('tahun_kendaraan',$this->tahun_kendaraan,true);
		$criteria->compare('merek_kendaraan',$this->merek_kendaraan,true);
		$criteria->compare('tipe_kendaraan',$this->tipe_kendaraan,true);
		$criteria->compare('id_jenis_kendaraan',$this->id_jenis_kendaraan,true);
		$criteria->compare('id_sub_jenis_kendaraan',$this->id_sub_jenis_kendaraan,true);
		$criteria->compare('tahun_buat',$this->tahun_buat,true);
		$criteria->compare('cc',$this->cc,true);
		$criteria->compare('daya_motor',$this->daya_motor,true);
		$criteria->compare('no_srut',$this->no_srut,true);
		$criteria->compare('tanggal_srut',$this->tanggal_srut,true);
		$criteria->compare('konfigurasi_sumbu',$this->konfigurasi_sumbu,true);
		$criteria->compare('jbb',$this->jbb,true);
		$criteria->compare('daya_angkut_barang',$this->daya_angkut_barang,true);
		$criteria->compare('daya_angkut_penumpang',$this->daya_angkut_penumpang,true);
		$criteria->compare('jbi',$this->jbi);
		$criteria->compare('mst',$this->mst);
		$criteria->compare('panjang_k',$this->panjang_k,true);
		$criteria->compare('lebar_k',$this->lebar_k,true);
		$criteria->compare('tinggi_k',$this->tinggi_k,true);
		$criteria->compare('julur_belakang',$this->julur_belakang,true);
		$criteria->compare('julur_depan',$this->julur_depan,true);
		$criteria->compare('q',$this->q,true);
		$criteria->compare('p',$this->p,true);
		$criteria->compare('a',$this->a,true);
		$criteria->compare('b',$this->b);
		$criteria->compare('sumbu12',$this->sumbu12,true);
		$criteria->compare('sumbu23',$this->sumbu23,true);
		$criteria->compare('sumbu34',$this->sumbu34,true);
		$criteria->compare('panjang_b',$this->panjang_b,true);
		$criteria->compare('lebar_b',$this->lebar_b,true);
		$criteria->compare('tinggi_b',$this->tinggi_b,true);
		$criteria->compare('bahan_b',$this->bahan_b,true);
		$criteria->compare('panjang_t',$this->panjang_t);
		$criteria->compare('lebar_t',$this->lebar_t);
		$criteria->compare('tinggi_t',$this->tinggi_t);
		$criteria->compare('volume_t',$this->volume_t);
		$criteria->compare('bahan_t',$this->bahan_t,true);
		$criteria->compare('berat_kosong_s1',$this->berat_kosong_s1,true);
		$criteria->compare('berat_kosong_s2',$this->berat_kosong_s2,true);
		$criteria->compare('berat_kosong_s3',$this->berat_kosong_s3,true);
		$criteria->compare('berat_kosong_s4',$this->berat_kosong_s4,true);
		$criteria->compare('berat_kosong',$this->berat_kosong);
		$criteria->compare('d_orang',$this->d_orang,true);
		$criteria->compare('eq_orang',$this->eq_orang,true);
		$criteria->compare('d_barang',$this->d_barang,true);
		$criteria->compare('jbki',$this->jbki,true);
		$criteria->compare('kelas_jalan',$this->kelas_jalan,true);
		$criteria->compare('bahan_bakar',$this->bahan_bakar,true);
		$criteria->compare('warna_kendaraan',$this->warna_kendaraan,true);
		$criteria->compare('bentuk',$this->bentuk,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VKendaraanProvinsi the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
