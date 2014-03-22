<?php if(!empty($success)): ?>
    <div class="success">
        <p><?php echo $success ?></p>
    </div>
<?php endif; ?>
<form class="form-registrate" name="edit_student" action="<?php echo URL::base() ?>students/edit/<?php echo $user->id ?>" method="POST" enctype="multipart/form-data">
    <div class="group-field-block">
        <label for="academic_year"><strong>STUDENTS ADMISSION FORM FOR GRADES 1-12 ACADEMIC YEAR</strong></label>
        <select name="academic_year" id="academic_year" <?php echo $teacher ? 'disabled' : '' ?>>
            <?php $levels = ORM::factory('level')->order_by('order')->find_all(); ?>
            <?php foreach($levels as $level): ?>
            <option value="<?php echo $level->id ?>" <?php echo $level->id == $user_data['academic_year'] ? 'selected' : '' ?>><?php echo $level->name ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <fieldset>
        <div class="group-field-block">
            <label for="name">Name</label>
            <input <?php echo $teacher ? 'disabled' : '' ?> type="text" name="name" id="name" value="<?php echo Helper_Main::getPostValue('name') ? Helper_Main::getPostValue('name') : Helper_Main::getValue('name', $user_data) ?>">
        </div>
        <div class="group-field-block">
            <label for="fathername">Father's Name</label>
            <input <?php echo $teacher ? 'disabled' : '' ?> type="text" name="fathername" id="fathername" value="<?php echo Helper_Main::getPostValue('fathername') ? Helper_Main::getPostValue('fathername') : Helper_Main::getValue('fathername', $user_data) ?>">
        </div>
        <div class="group-field-block">
            <label for="grfathername">Grandfather's Name</label>
            <input <?php echo $teacher ? 'disabled' : '' ?> type="text" name="grfathername" id="grfathername" value="<?php echo Helper_Main::getPostValue('grfathername') ? Helper_Main::getPostValue('grfathername') : Helper_Main::getValue('grfathername', $user_data) ?>">
        </div>
    </fieldset>
    <fieldset style="margin-top: 10px">
        <div class="group-field-block">
            <label for="dob_ec">Date of birth (E.C)</label>
            <input <?php echo $teacher ? 'disabled' : '' ?> type="text" name="dob[ec]" id="dob_ec" value="<?php echo Helper_Main::getPostValue('dob.ec') ? Helper_Main::getPostValue('dob.ec') : Helper_Main::getValue('dob.ec', $user_data) ?>">
            <label for="dob_gc">(G.C)</label>
            <input <?php echo $teacher ? 'disabled' : '' ?> type="text" name="dob[gc]" id="dob_gc" value="<?php echo Helper_Main::getPostValue('dob.gc') ? Helper_Main::getPostValue('dob.gc') : Helper_Main::getValue('dob.gc', $user_data) ?>">
            <label for="sex">Sex</label>
            <select <?php echo $teacher ? 'disabled' : '' ?> name="sex" id="sex">
                <?php $sex = Helper_Main::getPostValue('sex') ? Helper_Main::getPostValue('sex') : Helper_Main::getValue('sex', $user_data) ?>
                <option value="0" <?php echo $sex == '0' ? 'selected': '' ?>>Male</option>
                <option value="1" <?php echo $sex == '1' ? 'selected': '' ?>>Female</option>
            </select>
        </div>

        <div class="group-field-block">
            <label for="address_kk">Home Address: Kifle Ketema</label>
            <input <?php echo $teacher ? 'disabled' : '' ?> type="text" name="address[kk]" id="address_kk" value="<?php echo Helper_Main::getPostValue('address.kk') ? Helper_Main::getPostValue('address.kk') : Helper_Main::getValue('address.kk', $user_data) ?>">
            <label for="address_k">Kebele</label>
            <input <?php echo $teacher ? 'disabled' : '' ?> type="text" name="address[k]" id="address_k" value="<?php echo Helper_Main::getPostValue('address.k') ? Helper_Main::getPostValue('address.k') : Helper_Main::getValue('address.k', $user_data) ?>">
            <label for="address_h">House No.</label>
            <input <?php echo $teacher ? 'disabled' : '' ?> type="text" name="address[h]" id="address_h" value="<?php echo Helper_Main::getPostValue('address.h') ? Helper_Main::getPostValue('address.h') : Helper_Main::getValue('address.h', $user_data) ?>">
        </div>
    </fieldset>
    
    <fieldset style="margin-top: 20px">
        <div class="group-field-block">
            <?php if(!empty($user_data['image'])): ?>
            <img src="<?php echo URL::base() . Kohana::$config->load('config')->get('image_dir') . $user_data['image'] ?>">
            <?php endif; ?>
            <label for="image">Photo</label>
            <input <?php echo $teacher ? 'disabled' : '' ?> type="file" name="image" id="image">
        </div>
    </fieldset>
    
    <fieldset style="margin-top: 10px">
        <div class="group-field-block">
            <label for="father_name">Name of father:</label>
            <input <?php echo $teacher ? 'disabled' : '' ?> type="text" name="father[name]" id="father_name" value="<?php echo Helper_Main::getPostValue('father.name') ? Helper_Main::getPostValue('father.name') : Helper_Main::getValue('father.name', $user_data) ?>">
        </div>
        <div class="group-field-block">
            <label for="father_occ">Occupation:</label>
            <input <?php echo $teacher ? 'disabled' : '' ?> type="text" name="father[occ]" id="father_occ" value="<?php echo Helper_Main::getPostValue('father.occ') ? Helper_Main::getPostValue('father.occ') : Helper_Main::getValue('father.occ', $user_data) ?>">
            <label for="father_pw">Place of work:</label>
            <input <?php echo $teacher ? 'disabled' : '' ?> type="text" name="father[pw]" id="father_pw" value="<?php echo Helper_Main::getPostValue('father.pw') ? Helper_Main::getPostValue('father.pw') : Helper_Main::getValue('father.pw', $user_data) ?>">
        </div>
        <div class="group-field-block">
            <label for="father_telephone_of">Telephone: Office:</label>
            <input <?php echo $teacher ? 'disabled' : '' ?> type="text" name="father[telephone][of]" id="father_telephone_of" value="<?php echo Helper_Main::getPostValue('father.telephone.of') ? Helper_Main::getPostValue('father.telephone.of') : Helper_Main::getValue('father.telephone.of', $user_data) ?>">
            <label for="father_telephone_m">Mobile</label>
            <input <?php echo $teacher ? 'disabled' : '' ?> type="text" name="father[telephone][m]" id="father_telephone_m" value="<?php echo Helper_Main::getPostValue('father.telephone.m') ? Helper_Main::getPostValue('father.telephone.m') : Helper_Main::getValue('father.telephone.m', $user_data) ?>">
            <label for="father_telephone_r">Residence</label>
            <input <?php echo $teacher ? 'disabled' : '' ?> type="text" name="father[telephone][r]" id="father_telephone_r" value="<?php echo Helper_Main::getPostValue('father.telephone.r') ? Helper_Main::getPostValue('father.telephone.r') : Helper_Main::getValue('father.telephone.r', $user_data) ?>">
        </div>
    </fieldset>
    <fieldset style="margin-top: 10px">
        <div class="group-field-block">
            <label for="mother_name">Name of mother:</label>
            <input <?php echo $teacher ? 'disabled' : '' ?> type="text" name="mother[name]" id="mother_name" value="<?php echo Helper_Main::getPostValue('mother.name') ? Helper_Main::getPostValue('mother.name') : Helper_Main::getValue('mother.name', $user_data) ?>">
        </div>
        <div class="group-field-block">
            <label for="mother_occ">Occupation:</label>
            <input <?php echo $teacher ? 'disabled' : '' ?> type="text" name="mother[occ]" id="mother_occ" value="<?php echo Helper_Main::getPostValue('mother.occ') ? Helper_Main::getPostValue('mother.occ') : Helper_Main::getValue('mother.occ', $user_data) ?>">
            <label for="mother_pw">Place of work:</label>
            <input <?php echo $teacher ? 'disabled' : '' ?> type="text" name="mother[pw]" id="mother_pw" value="<?php echo Helper_Main::getPostValue('mother.pw') ? Helper_Main::getPostValue('mother.pw') : Helper_Main::getValue('mother.pw', $user_data) ?>">
        </div>
        <div class="group-field-block">
            <label for="mother_telephone_of">Telephone: Office:</label>
            <input <?php echo $teacher ? 'disabled' : '' ?> type="text" name="mother[telephone][of]" id="mother_telephone_of" value="<?php echo Helper_Main::getPostValue('mother.telephone.of') ? Helper_Main::getPostValue('mother.telephone.of') : Helper_Main::getValue('mother.telephone.of', $user_data) ?>">
            <label for="mother_telephone_m">Mobile</label>
            <input <?php echo $teacher ? 'disabled' : '' ?> type="text" name="mother[telephone][m]" id="mother_telephone_m" value="<?php echo Helper_Main::getPostValue('mother.telephone.m') ? Helper_Main::getPostValue('mother.telephone.m') : Helper_Main::getValue('mother.telephone.m', $user_data) ?>">
            <label for="mother_telephone_r">Residence</label>
            <input <?php echo $teacher ? 'disabled' : '' ?> type="text" name="mother[telephone][r]" id="mother_telephone_r" value="<?php echo Helper_Main::getPostValue('mother.telephone.r') ? Helper_Main::getPostValue('mother.telephone.r') : Helper_Main::getValue('mother.telephone.r', $user_data) ?>">
        </div>
    </fieldset>
    <fieldset style="margin-top: 10px">
        <div class="group-field-block">
            <label for="guardian_name">Name of Guardian:</label>
            <input <?php echo $teacher ? 'disabled' : '' ?> type="text" name="guardian[name]" id="guardian_name" value="<?php echo Helper_Main::getPostValue('guardian.name') ? Helper_Main::getPostValue('guardian.name') : Helper_Main::getValue('guardian.name', $user_data) ?>">
            <label for="guardian_rel">Relation to the student</label>
            <input <?php echo $teacher ? 'disabled' : '' ?> type="text" name="guardian[rel]" id="guardian_rel" value="<?php echo Helper_Main::getPostValue('guardian.rel') ? Helper_Main::getPostValue('guardian.rel') : Helper_Main::getValue('guardian.rel', $user_data) ?>">
        </div>
        <div class="group-field-block">
            <label for="guardian_pw">Place of work:</label>
            <input <?php echo $teacher ? 'disabled' : '' ?> type="text" name="guardian[pw]" id="guardian_pw" value="<?php echo Helper_Main::getPostValue('guardian.pw') ? Helper_Main::getPostValue('guardian.pw') : Helper_Main::getValue('guardian.pw', $user_data) ?>">
            <label for="guardian_telephone_of">Tel. Office</label>
            <input <?php echo $teacher ? 'disabled' : '' ?> type="text" name="guardian[telephone][of]" id="guardian_telephone_of" value="<?php echo Helper_Main::getPostValue('guardian.telephone.of') ? Helper_Main::getPostValue('guardian.telephone.of') : Helper_Main::getValue('guardian.telephone.of', $user_data) ?>">
        </div>
        <div class="group-field-block">
            <label for="guardian_telephone_m">Mobile:</label>
            <input <?php echo $teacher ? 'disabled' : '' ?> type="text" name="guardian[telephone][m]" id="guardian_telephone_m" value="<?php echo Helper_Main::getPostValue('guardian.telephone.m') ? Helper_Main::getPostValue('guardian.telephone.m') : Helper_Main::getValue('guardian.telephone.m', $user_data) ?>">
        </div>
    </fieldset>
    <fieldset style="margin-top: 10px">
        <legend>Contacts telephones in case of emergency (give detailed information) </legend>
        <div class="tels">
        <?php foreach ($user_data['tels_em'] as $key => $tel): ?>
            <div class="group-field-block tel">
                <label for="tels_em_<?php echo $key ?>_name">Name</label>
                <input <?php echo $teacher ? 'disabled' : '' ?> type="text" name="tels_em[<?php echo $key ?>][name]" class="tels_em_name" id="tels_em_<?php echo $key ?>_name" value="<?php echo $tel['name'] ?>">
                <label for="tels_em_<?php echo $key ?>_tel">Tel. No.</label>
                <input <?php echo $teacher ? 'disabled' : '' ?> type="text" name="tels_em[<?php echo $key ?>][tel]" class="tels_em_tel" id="tels_em_<?php echo $key ?>_tel" value="<?php echo $tel['tel'] ?>">
            </div>
        <?php endforeach; ?>
        </div>
        <?php if(!$teacher): ?>
            <a href="#" id="more-tel"><img src="<?php echo URL::base() ?>img/add_icon.png"></a>
        <?php endif; ?>
    </fieldset>
    <fieldset style="margin-top: 10px">
        <legend>Languages spoken at home:</legend>
        <div class="group-field-block">
            <label for="languages_0">1.</label>
            <input <?php echo $teacher ? 'disabled' : '' ?> type="text" name="languages[0]" id="languages_0" value="<?php echo Helper_Main::getPostValue('languages.0') ? Helper_Main::getPostValue('languages.0') : Helper_Main::getValue('languages.0', $user_data) ?>">
            <label for="languages_1">2.</label>
            <input <?php echo $teacher ? 'disabled' : '' ?> type="text" name="languages[1]" id="languages_1" value="<?php echo Helper_Main::getPostValue('languages.1') ? Helper_Main::getPostValue('languages.1') : Helper_Main::getValue('languages.1', $user_data) ?>">
            <label for="languages_2">3.</label>
            <input <?php echo $teacher ? 'disabled' : '' ?> type="text" name="languages[2]" id="languages_2" value="<?php echo Helper_Main::getPostValue('languages.2') ? Helper_Main::getPostValue('languages.2') : Helper_Main::getValue('languages.2', $user_data) ?>">
        </div>
    </fieldset>
    <fieldset style="margin-top: 10px">
        <legend>Any health conditions that the school should know about:</legend>
        <div class="group-field-block">
            <label for="health">Please specify:</label>
            <input <?php echo $teacher ? 'disabled' : '' ?> type="text" name="health" id="health" value="<?php echo Helper_Main::getPostValue('health') ? Helper_Main::getPostValue('health') : Helper_Main::getValue('health', $user_data) ?>">
        </div>
    </fieldset>
    <fieldset style="margin-top: 10px">
        <legend>Does the applicant have any siblings (brothers or sisters) learning in Dandii Boru School? If yes give particulars </legend>
        <div class="siblings">
        <?php foreach($user_data['siblings'] as $key => $sib): ?>
            <div class="group-field-block sib">
                <label for="siblings_<?php echo $key ?>_name">Name</label>
                <input <?php echo $teacher ? 'disabled' : '' ?> type="text" name="siblings[<?php echo $key ?>][name]" class="siblings_name" id="siblings_<?php echo $key ?>_name" value="<?php echo $sib['name'] ?>">
                <label for="siblings_<?php echo $key ?>_grade">Grade & section</label>
                <input <?php echo $teacher ? 'disabled' : '' ?> type="text" name="siblings[<?php echo $key ?>][grade]" class="siblings_grade" id="siblings_<?php echo $key ?>_grade" value="<?php echo $sib['grade'] ?>">
                <label for="siblings_<?php echo $key ?>_rel">Relation</label>
                <input <?php echo $teacher ? 'disabled' : '' ?> type="text" name="siblings[<?php echo $key ?>][rel]" class="siblings_rel" id="siblings_<?php echo $key ?>_rel" value="<?php echo $sib['rel'] ?>">
            </div>
        <?php endforeach; ?>
        </div>
        <?php if(!$teacher): ?>
            <a href="#" id="more-sib"><img src="<?php echo URL::base() ?>img/add_icon.png"></a>
        <?php endif; ?>
    </fieldset>
    <?php if(!$teacher): ?>
        <input type="submit" style="cursor: pointer" value="Edit">
    <?php endif; ?>
    <input type="button" style="cursor: pointer" value="Cancel" onclick="javascript: location.href='<?php echo URL::base() ?>students/list'">
</form>