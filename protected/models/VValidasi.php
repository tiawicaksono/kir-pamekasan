<?php

/**
 * This is the model class for table "v_validasi".
 *
 * The followings are the available columns in table 'v_validasi':
 * @property string $nm_uji
 * @property string $no_uji
 * @property string $no_kendaraan
 * @property string $numerator
 * @property integer $lama_tlt
 * @property boolean $validasi
 * @property string $tglmati
 * @property string $tgl_retribusi
 * @property string $id_retribusi
 * @property string $jns_kend
 * @property string $penerima
 * @property string $nama_pemilik
 * @property string $ptgs_valid
 * @property string $tgl_uji
 * @property string $alamat
 * @property string $jenis
 * @property string $id_uji
 * @property string $id_kendaraan
 * @property double $b_berkala
 * @property double $b_pertama
 * @property double $b_tlt_uji
 * @property double $b_plat_uji
 * @property double $b_buku
 * @property double $b_tnd_samping
 * @property double $b_jbb_lebih
 * @property double $b_jbb_kurang
 * @property double $b_jbb
 * @property double $b_rekom
 * @property double $total
 */
class VValidasi extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'v_validasi';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lama_tlt', 'numerical', 'integerOnly'=>true),
			array('b_berkala, b_pertama, b_tlt_uji, b_plat_uji, b_buku, b_tnd_samping, b_jbb_lebih, b_jbb_kurang, b_jbb, b_rekom, total', 'numerical'),
			array('nm_uji, penerima', 'length', 'max'=>50),
			array('no_uji', 'length', 'max'=>30),
			array('jns_kend', 'length', 'max'=>40),
			array('ptgs_valid', 'length', 'max'=>20),
			array('no_kendaraan, numerator, validasi, tglmati, tgl_retribusi, id_retribusi, nama_pemilik, tgl_uji, alamat, jenis, id_uji, id_kendaraan', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('nm_uji, no_uji, no_kendaraan, numerator, lama_tlt, validasi, tglmati, tgl_retribusi, id_retribusi, jns_kend, penerima, nama_pemilik, ptgs_valid, tgl_uji, alamat, jenis, id_uji, id_kendaraan, b_berkala, b_pertama, b_tlt_uji, b_plat_uji, b_buku, b_tnd_samping, b_jbb_lebih, b_jbb_kurang, b_jbb, b_rekom, total', 'safe', 'on'=>'search'),
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
			'nm_uji' => 'Nm Uji',
			'no_uji' => 'No Uji',
			'no_kendaraan' => 'No Kendaraan',
			'numerator' => 'Numerator',
			'lama_tlt' => 'Lama Tlt',
			'validasi' => 'Validasi',
			'tglmati' => 'Tglmati',
			'tgl_retribusi' => 'Tgl Retribusi',
			'id_retribusi' => 'Id Retribusi',
			'jns_kend' => 'Jns Kend',
			'penerima' => 'Penerima',
			'nama_pemilik' => 'Nama Pemilik',
			'ptgs_valid' => 'Ptgs Valid',
			'tgl_uji' => 'Tgl Uji',
			'alamat' => 'Alamat',
			'jenis' => 'Jenis',
			'id_uji' => 'Id Uji',
			'id_kendaraan' => 'Id Kendaraan',
			'b_berkala' => 'B Berkala',
			'b_pertama' => 'B Pertama',
			'b_tlt_uji' => 'B Tlt Uji',
			'b_plat_uji' => 'B Plat Uji',
			'b_buku' => 'B Buku',
			'b_tnd_samping' => 'B Tnd Samping',
			'b_jbb_lebih' => 'B Jbb Lebih',
			'b_jbb_kurang' => 'B Jbb Kurang',
			'b_jbb' => 'B Jbb',
			'b_rekom' => 'B Rekom',
			'total' => 'Total',
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

		$criteria->compare('nm_uji',$this->nm_uji,true);
		$criteria->compare('no_uji',$this->no_uji,true);
		$criteria->compare('no_kendaraan',$this->no_kendaraan,true);
		$criteria->compare('numerator',$this->numerator,true);
		$criteria->compare('lama_tlt',$this->lama_tlt);
		$criteria->compare('validasi',$this->validasi);
		$criteria->compare('tglmati',$this->tglmati,true);
		$criteria->compare('tgl_retribusi',$this->tgl_retribusi,true);
		$criteria->compare('id_retribusi',$this->id_retribusi,true);
		$criteria->compare('jns_kend',$this->jns_kend,true);
		$criteria->compare('penerima',$this->penerima,true);
		$criteria->compare('nama_pemilik',$this->nama_pemilik,true);
		$criteria->compare('ptgs_valid',$this->ptgs_valid,true);
		$criteria->compare('tgl_uji',$this->tgl_uji,true);
		$criteria->compare('alamat',$this->alamat,true);
		$criteria->compare('jenis',$this->jenis,true);
		$criteria->compare('id_uji',$this->id_uji,true);
		$criteria->compare('id_kendaraan',$this->id_kendaraan,true);
		$criteria->compare('b_berkala',$this->b_berkala);
		$criteria->compare('b_pertama',$this->b_pertama);
		$criteria->compare('b_tlt_uji',$this->b_tlt_uji);
		$criteria->compare('b_plat_uji',$this->b_plat_uji);
		$criteria->compare('b_buku',$this->b_buku);
		$criteria->compare('b_tnd_samping',$this->b_tnd_samping);
		$criteria->compare('b_jbb_lebih',$this->b_jbb_lebih);
		$criteria->compare('b_jbb_kurang',$this->b_jbb_kurang);
		$criteria->compare('b_jbb',$this->b_jbb);
		$criteria->compare('b_rekom',$this->b_rekom);
		$criteria->compare('total',$this->total);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VValidasi the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
