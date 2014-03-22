<div id="tab-2">
    <div class="sepH_c">
<?php if(!empty($errors)): ?>
    <div class="error">
        <?php foreach($errors as $error): ?>
            <p><?php echo $error ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
        <form class="form-registrate" name="create_student" action="<?php echo URL::base() ?>students/new" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="status" value="1">
            <div class="group-field-block">
                <label for="academic_year"><strong>STUDENTS ADMISSION FORM FOR GRADES 1-12 ACADEMIC YEAR</strong></label>
                <select name="academic_year" id="academic_year">
                    <?php $levels = ORM::factory('level')->order_by('order')->find_all(); ?>
                    <?php foreach($levels as $level): ?>
                        <option value="<?php echo $level->id ?>" <?php echo $level->id == Helper_Main::getPostValue('academic_year') ? 'selected' : '' ?>><?php echo $level->name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <fieldset>
                <div class="group-field-block">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" value="<?php echo Helper_Main::getPostValue('name') ?>">
                </div>
                <div class="group-field-block">
                    <label for="fathername">Father's Name</label>
                    <input type="text" name="fathername" id="fathername" value="<?php echo Helper_Main::getPostValue('fathername') ?>">
                </div>
                <div class="group-field-block">
                    <label for="grfathername">Grandfather's Name</label>
                    <input type="text" name="grfathername" id="grfathername" value="<?php echo Helper_Main::getPostValue('grfathername') ?>">
                </div>
                <div class="group-field-block">
                    <label for="dob_ec">Date of birth (E.C)</label>
                    <input type="text" name="dob[ec]" id="dob_ec" value="<?php echo Helper_Main::getPostValue('dob.ec') ? Helper_Main::getPostValue('dob.ec') : '' ?>">
                    <label for="dob_gc">(G.C)</label>
                    <input type="text" name="dob[gc]" id="dob_gc" value="<?php echo Helper_Main::getPostValue('dob.gc') ? Helper_Main::getPostValue('dob.gc') : date('d-m-y') ?>">
                    <label for="sex">Sex</label>
                    <select name="sex" id="sex">
                        <option value="0" <?php echo Helper_Main::getPostValue('sex') == '0' ? 'selected': '' ?>>Male</option>
                        <option value="1" <?php echo Helper_Main::getPostValue('sex') == '1' ? 'selected': '' ?>>Female</option>
                    </select>
                </div>
                <div class="group-field-block">
                    <label for="address_kk">Home Address: Kifle Ketema</label>
                    <input type="text" name="address[kk]" id="address_kk" value="<?php echo Helper_Main::getPostValue('address.kk') ?>">
                    <label for="address_k">Kebele</label>
                    <input type="text" name="address[k]" id="address_k" value="<?php echo Helper_Main::getPostValue('address.k') ?>">
                    <label for="address_h">House No.</label>
                    <input type="text" name="address[h]" id="address_h" value="<?php echo Helper_Main::getPostValue('address.h') ?>">
                </div>
            </fieldset>

            <fieldset style="margin-top: 20px">
                <div class="group-field-block">
                    <label for="image">Photo</label>
                    <input type="file" name="image" id="image">
                </div>
            </fieldset>

            <fieldset style="margin-top: 10px">
                <div class="group-field-block">
                    <label for="father_name">Name of father:</label>
                    <input type="text" name="father[name]" id="father_name" value="<?php echo Helper_Main::getPostValue('father.name') ?>">
                </div>
                <div class="group-field-block">
                    <label for="father_occ">Occupation:</label>
                    <input type="text" name="father[occ]" id="father_occ" value="<?php echo Helper_Main::getPostValue('father.occ') ?>">
                    <label for="father_pw">Place of work:</label>
                    <input type="text" name="father[pw]" id="father_pw" value="<?php echo Helper_Main::getPostValue('father.pw') ?>">
                </div>
                <div class="group-field-block">
                    <label for="father_telephone_of">Telephone: Office:</label>
                    <input type="text" name="father[telephone][of]" id="father_telephone_of" value="<?php echo Helper_Main::getPostValue('father.telephone.of') ?>">
                    <label for="father_telephone_m">Mobile</label>
                    <input type="text" name="father[telephone][m]" id="father_telephone_m" value="<?php echo Helper_Main::getPostValue('father.telephone.m') ?>">
                    <label for="father_telephone_r">Residence</label>
                    <input type="text" name="father[telephone][r]" id="father_telephone_r" value="<?php echo Helper_Main::getPostValue('father.telephone.r') ?>">
                </div>
            </fieldset>
            <fieldset style="margin-top: 10px">
                <div class="group-field-block">
                    <label for="mother_name">Name of mother:</label>
                    <input type="text" name="mother[name]" id="mother_name" value="<?php echo Helper_Main::getPostValue('mother.name') ?>">
                </div>
                <div class="group-field-block">
                    <label for="mother_occ">Occupation:</label>
                    <input type="text" name="mother[occ]" id="mother_occ" value="<?php echo Helper_Main::getPostValue('mother.occ') ?>">
                    <label for="mother_pw">Place of work:</label>
                    <input type="text" name="mother[pw]" id="mother_pw" value="<?php echo Helper_Main::getPostValue('mother.pw') ?>">
                </div>
                <div class="group-field-block">
                    <label for="mother_telephone_of">Telephone: Office:</label>
                    <input type="text" name="mother[telephone][of]" id="mother_telephone_of" value="<?php echo Helper_Main::getPostValue('mother.telephone.of') ?>">
                    <label for="mother_telephone_m">Mobile</label>
                    <input type="text" name="mother[telephone][m]" id="mother_telephone_m" value="<?php echo Helper_Main::getPostValue('mother.telephone.m') ?>">
                    <label for="mother_telephone_r">Residence</label>
                    <input type="text" name="mother[telephone][r]" id="mother_telephone_r" value="<?php echo Helper_Main::getPostValue('mother.telephone.r') ?>">
                </div>
            </fieldset>
            <fieldset style="margin-top: 10px">
                <div class="group-field-block">
                    <label for="guardian_name">Name of Guardian:</label>
                    <input type="text" name="guardian[name]" id="guardian_name" value="<?php echo Helper_Main::getPostValue('guardian.name') ?>">
                    <label for="guardian_rel">Relation to the student</label>
                    <input type="text" name="guardian[rel]" id="guardian_rel" value="<?php echo Helper_Main::getPostValue('guardian.rel') ?>">
                </div>
                <div class="group-field-block">
                    <label for="guardian_pw">Place of work:</label>
                    <input type="text" name="guardian[pw]" id="guardian_pw" value="<?php echo Helper_Main::getPostValue('guardian.pw') ?>">
                    <label for="guardian_telephone_of">Tel. Office</label>
                    <input type="text" name="guardian[telephone][of]" id="guardian_telephone_of" value="<?php echo Helper_Main::getPostValue('guardian.telephone.of') ?>">
                </div>
                <div class="group-field-block">
                    <label for="guardian_telephone_m">Mobile:</label>
                    <input type="text" name="guardian[telephone][m]" id="guardian_telephone_m" value="<?php echo Helper_Main::getPostValue('guardian.telephone.m') ?>">
                </div>
            </fieldset>
            <fieldset style="margin-top: 10px">
                <legend>Contacts telephones in case of emergency (give detailed information) </legend>
                <div class="tels">
                    <div class="group-field-block tel">
                        <label for="tels_em_0_name">Name</label>
                        <input type="text" name="tels_em[0][name]" id="tels_em_0_name" class="tels_em_name" value="<?php echo Helper_Main::getPostValue('tels_em.0.name') ?>">
                        <label for="tels_em_0_tel">Tel. No.</label>
                        <input type="text" name="tels_em[0][tel]" id="tels_em_0_tel" class="tels_em_tel" value="<?php echo Helper_Main::getPostValue('tels_em.0.tel') ?>">
                    </div>
                </div>
                <a href="#" id="more-tel"><img src="<?php echo URL::base() ?>img/add_icon.png"></a>
            </fieldset>
            <fieldset style="margin-top: 10px">
                <legend>Languages spoken at home:</legend>
                <div class="group-field-block">
                    <label for="languages_0">1.</label>
                    <input type="text" name="languages[0]" id="languages_0" value="<?php echo Helper_Main::getPostValue('languages.0') ?>">
                    <label for="languages_1">2.</label>
                    <input type="text" name="languages[1]" id="languages_1" value="<?php echo Helper_Main::getPostValue('languages.1') ?>">
                    <label for="languages_2">3.</label>
                    <input type="text" name="languages[2]" id="languages_2" value="<?php echo Helper_Main::getPostValue('languages.2') ?>">
                </div>
            </fieldset>
            <fieldset style="margin-top: 10px">
                <legend>Any health conditions that the school should know about:</legend>
                <div class="group-field-block">
                    <label for="health">Please specify:</label>
                    <input type="text" name="health" id="health" value="<?php echo Helper_Main::getPostValue('health') ?>">
                </div>
            </fieldset>
            <fieldset style="margin-top: 10px">
                <legend>Does the applicant have any siblings (brothers or sisters) learning in Dandii Boru School? If yes give particulars </legend>
                <div class="siblings">
                    <div class="group-field-block sib">
                        <label for="siblings_0_name">Name</label>
                        <input type="text" name="siblings[0][name]" id="siblings_0_name" class="siblings_name" value="<?php echo Helper_Main::getPostValue('siblings.0.name') ?>">
                        <label for="siblings_0_grade">Grade & section</label>
                        <input type="text" name="siblings[0][grade]" id="siblings_0_grade" class="siblings_grade" value="<?php echo Helper_Main::getPostValue('siblings.0.grade') ?>">
                        <label for="siblings_0_rel">Relation</label>
                        <input type="text" name="siblings[0][rel]" id="siblings_0_rel" class="siblings_rel" value="<?php echo Helper_Main::getPostValue('siblings.0.rel') ?>">
                    </div>
                </div>
                <a href="#" id="more-sib"><img src="<?php echo URL::base() ?>img/add_icon.png"></a>
            </fieldset>
            <input type="submit" value="Create student">
        </form>
    </div>
</div>