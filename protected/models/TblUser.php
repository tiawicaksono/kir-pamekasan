<?php

/**
 * This is the model class for table "tbl_user".
 *
 * The followings are the available columns in table 'tbl_user':
 * @property string $user_name
 * @property string $user_pass
 * @property string $id_user
 * @property boolean $prauji
 * @property boolean $emisi
 * @property boolean $pitlift
 * @property boolean $lampu
 * @property boolean $brake
 * @property boolean $gandengan
 * @property integer $position_id
 * @property string $alat_uji
 */
class TblUser extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function primaryKey() {
        return array('id_user');
    }
    
    public function tableName() {
        return 'tbl_user';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_name', 'required'),
            array('position_id', 'numerical', 'integerOnly' => true),
            array('user_name', 'length', 'max' => 100),
            array('alat_uji', 'length', 'max' => 20),
            array('user_pass, prauji, emisi, pitlift, lampu, brake, gandengan', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('user_name, user_pass, id_user, prauji, emisi, pitlift, lampu, brake, gandengan, position_id, alat_uji', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'user_name' => 'User Name',
            'user_pass' => 'User Pass',
            'id_user' => 'Id User',
            'prauji' => 'Prauji',
            'emisi' => 'Emisi',
            'pitlift' => 'Pitlift',
            'lampu' => 'Lampu',
            'brake' => 'Brake',
            'gandengan' => 'Gandengan',
            'position_id' => 'Position',
            'alat_uji' => 'Alat Uji',
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('user_name', $this->user_name, true);
        $criteria->compare('user_pass', $this->user_pass, true);
        $criteria->compare('id_user', $this->id_user, true);
        $criteria->compare('prauji', $this->prauji);
        $criteria->compare('emisi', $this->emisi);
        $criteria->compare('pitlift', $this->pitlift);
        $criteria->compare('lampu', $this->lampu);
        $criteria->compare('brake', $this->brake);
        $criteria->compare('gandengan', $this->gandengan);
        $criteria->compare('position_id', $this->position_id);
        $criteria->compare('alat_uji', $this->alat_uji, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return TblUser the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
