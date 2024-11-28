<div class="row col-md-12">
    <h3 class="title">BRAKE</h3>
    <div class="bs-example">
        <table width="100%">
            <tr>
                <td width="118"></td>
                <td width="74">GAYA REM</td>
                <td width="18" align="left"></td>
                <td width="88" align="left"></td>
                <td width="77" align="left">SELISIH REM</td>
                <td width="32" align="left"></td>
                <td width="176" align="left"></td>
            </tr>
            <tr>
                <td>1. SUMBU I </td>
                <td width="74">
                    <div class="form-group">
                        <label class="sr-only" for="bsb1"></label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="bsb1" value="<?php echo $selrem1; ?>">
                            <div class="input-group-addon">%</div>
                        </div>
                    </div>
                </td>
                <td width="18" align="left"></td>
                <td width="88" align="left">Min = 50 %</td>
                <td width="77" align="left">
                    <div class="form-group">
                        <label class="sr-only" for="bsel1"></label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="bsel1" value="<?php echo $selgaya1; ?>">
                            <div class="input-group-addon">%</div>
                        </div>
                    </div>
                </td>
                <td width="32" align="left"></td>
                <td width="176" align="left">Max = 8 %</td>
                <td></td>
            </tr>
            <tr>
                <td>2. SUMBU II </td>
                <td width="74">
                    <div class="form-group">
                        <label class="sr-only" for="bsb2"></label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="bsb2" value="<?php echo $selrem2; ?>">
                            <div class="input-group-addon">%</div>
                        </div>
                    </div>
                </td>
                <td width="18" align="left"></td>
                <td width="88" align="left">Min = 50 %</td>
                <td width="77" align="left">
                    <div class="form-group">
                        <label class="sr-only" for="bsel2"></label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="bsel2" value="<?php echo $selgaya2; ?>">
                            <div class="input-group-addon">%</div>
                        </div>
                    </div>
                </td>
                <td width="32" align="left"></td>
                <td width="176" align="left">Max = 8 %</td>
                <td></td>
            </tr>
            <tr>
                <td>3. SUMBU III </td>
                <td width="74">
                    <div class="form-group">
                        <label class="sr-only" for="bsb3"></label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="bsb3" value="<?php echo $selrem3; ?>">
                            <div class="input-group-addon">%</div>
                        </div>
                    </div>
                </td>
                <td width="18" align="left">%</td>
                <td width="88" align="left">Min = 50 %</td>
                <td width="77" align="left">
                    <div class="form-group">
                        <label class="sr-only" for="bsel3"></label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="bsel3" value="<?php echo $selgaya3; ?>">
                            <div class="input-group-addon">%</div>
                        </div>
                    </div>
                </td>
                <td width="32" align="left"></td>
                <td width="176" align="left">Max = 8 %</td>
                <td></td>
            </tr>
            <tr>
                <td>4. SUMBU IV </td>
                <td width="74">
                    <div class="form-group">
                        <label class="sr-only" for="bsb4"></label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="bsb4" value="<?php echo $selrem4; ?>">
                            <div class="input-group-addon">%</div>
                        </div>
                    </div>
                </td>
                <td width="18" align="left"></td>
                <td width="88" align="left">Min = 50 %</td>
                <td width="77" align="left">
                    <div class="form-group">
                        <label class="sr-only" for="bsel4"></label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="bsel4" value="<?php echo $selgaya4; ?>">
                            <div class="input-group-addon">%</div>
                        </div>
                    </div>
                </td>
                <td width="32" align="left"></td>
                <td width="176" align="left">Max = 8 %</td>
                <td></td>
            </tr>
            <tr>
                <td colspan="8">
                    <div class="checkbox">
                        <label>
                            <input id="um21" type="checkbox">
                            Berat sumbu I tidak sesui dengan STUK
                        </label>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="8">
                    <div class="checkbox">
                        <label>
                            <input id="um22" type="checkbox">
                            Berat sumbu II tidak sesui dengan STUK
                        </label>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="8">
                    <div class="checkbox">
                        <label>
                            <input id="um23" type="checkbox">
                            Berat sumbu III tidak sesui dengan STUK
                        </label>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="8">
                    <div class="checkbox">
                        <label>
                            <input id="um24" type="checkbox">
                            Berat sumbu IV tidak sesui dengan STUK
                        </label>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="8">
                    <div class="checkbox">
                        <label>
                            <input id="um33" type="checkbox">
                            Efisiensi rem parkir kurang dari 17%
                        </label>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</div>
<div class="row col-md-12">
    <div class="col-md-6">
        <label class="col-md-3 control-label">&nbsp;</label>
        <div class="col-md-9 no-padding">
            <button type="button" class="btn btn-primary pull-right" id="prosesBrake" onclick="prosesClickBrake('<?php echo $this->createUrl('Verifikasi/ProsesBrake'); ?>')">SAVE</button>
        </div>
    </div>
</div>