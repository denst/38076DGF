<?php if(!empty($success)): ?>
    <div class="success">
        <p><?php echo $success ?></p>
    </div>
<?php endif; ?>
<form class="form-registrate" name="admin_teacher_edit" action="<?php echo URL::base() ?>teachers/edit/<?php echo $user->id ?>" method="POST" enctype="multipart/form-data">
    <fieldset>
        <div class="group-field-block">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" value="<?php echo Helper_Main::getPostValue('name') ? Helper_Main::getPostValue('name') : Helper_Main::getValue('name', $user_data) ?>">
        </div>
         <div class="group-field-block">
            <label for="fathername">Father's Name</label>
            <input type="text" name="fathername" id="fathername" value="<?php echo Helper_Main::getPostValue('fathername') ? Helper_Main::getPostValue('fathername') : Helper_Main::getValue('fathername', $user_data) ?>">
        </div>
        <div class="group-field-block">
            <label for="grfathername">Grand Father's Name</label>
            <input type="text" name="grfathername" id="grfathername" value="<?php echo Helper_Main::getPostValue('grfathername') ? Helper_Main::getPostValue('grfathername') : Helper_Main::getValue('grfathername', $user_data) ?>">
        </div>
    </fieldset>
    
    <fieldset style="margin-top: 20px">
        <div class="group-field-block">
            <?php if(!empty($user_data['image'])): ?>
            <img src="<?php echo URL::base() . Kohana::$config->load('config')->get('image_dir') . $user_data['image'] ?>">
            <?php endif; ?>
            <label for="image">Photo</label>
            <input type="file" name="image" id="image">
        </div>
    </fieldset>
    
    <fieldset style="margin-top: 20px">
        <div class="group-field-block">
            <label for="dob">Date of birth (E.C) </label>
            <input type="text" name="dob" id="dob" value="<?php echo Helper_Main::getPostValue('dob') ? Helper_Main::getPostValue('dob') : Helper_Main::getValue('dob', $user_data) ?>">
            <label for="sex">Sex</label>
            <select name="sex" id="sex">
                <?php $sex = Helper_Main::getPostValue('sex') ? Helper_Main::getPostValue('sex') : Helper_Main::getValue('sex', $user_data) ?>
                <option value="0" <?php echo $sex == '0' ? 'selected': '' ?>>Male</option>
                <option value="1" <?php echo $sex == '1' ? 'selected': '' ?>>Female</option>
            </select>
        </div>
        <div class="group-field-block">
            <label for="address_kk">Home Address: Kifle Ketema</label>
            <input type="text" name="home_address[kk]" id="address_kk" value="<?php echo Helper_Main::getPostValue('home_address.kk') ? Helper_Main::getPostValue('home_address.kk') : Helper_Main::getValue('home_address.kk', $user_data) ?>">
            <label for="address_k">Kebele</label>
            <input type="text" name="home_address[k]" id="address_k" value="<?php echo Helper_Main::getPostValue('home_address.k') ? Helper_Main::getPostValue('home_address.k') : Helper_Main::getValue('home_address.k', $user_data) ?>">
            <label for="address_h">House No.</label>
            <input type="text" name="home_address[h]" id="address_h" value="<?php echo Helper_Main::getPostValue('home_address.h') ? Helper_Main::getPostValue('home_address.h') : Helper_Main::getValue('home_address.h', $user_data) ?>">
        </div>
        <div class="group-field-block">
            <label for="lpw">Last Place of work:</label>
            <input type="text" name="lpw" id="lpw" value="<?php echo Helper_Main::getPostValue('lpw') ? Helper_Main::getPostValue('lpw') : Helper_Main::getValue('lpw', $user_data) ?>">
        </div>
        <div class="group-field-block">
            <label for="job">Job Title:</label>
            <input type="text" name="job" id="job" value="<?php echo Helper_Main::getPostValue('job') ? Helper_Main::getPostValue('job') : Helper_Main::getValue('job', $user_data) ?>">
        </div>
        <div class="group-field-block">
            <label for="contact_name">Contact Name (Reference):</label>
            <input type="text" name="contact_name" id="contact_name" value="<?php echo Helper_Main::getPostValue('contact_name') ? Helper_Main::getPostValue('contact_name') : Helper_Main::getValue('contact_name', $user_data) ?>">
        </div>
        <div class="group-field-block">
            <label for="address">Address:</label>
            <input type="text" name="address" id="address" value="<?php echo Helper_Main::getPostValue('address') ? Helper_Main::getPostValue('address') : Helper_Main::getValue('address', $user_data) ?>">
        </div>
        <div class="group-field-block">
            <label for="telephone_of">Telephone: Office:</label>
            <input type="text" name="telephone[of]" id="telephone_of" value="<?php echo Helper_Main::getPostValue('telephone.of') ? Helper_Main::getPostValue('telephone.of') : Helper_Main::getValue('telephone.of', $user_data) ?>">
            <label for="telephone_m">Mobile</label>
            <input type="text" name="telephone[m]" id="telephone_m" value="<?php echo Helper_Main::getPostValue('telephone.m') ? Helper_Main::getPostValue('telephone.m') : Helper_Main::getValue('telephone.m', $user_data) ?>">
        </div>
    </fieldset>
    
    <fieldset style="margin-top: 20px">
        <div class="group-field-block">
            <label for="emergency_contact">Emergency Contact:</label>
            <input type="text" name="emergency[contact]" id="emergency_contact" value="<?php echo Helper_Main::getPostValue('emergency.contact') ? Helper_Main::getPostValue('emergency.contact') : Helper_Main::getValue('emergency.contact', $user_data) ?>">
        </div>
        <div class="group-field-block">
            <label for="emergency_relation">Relation to you:</label>
            <input type="text" name="emergency[relation]" id="emergency_relation" value="<?php echo Helper_Main::getPostValue('emergency.relation') ? Helper_Main::getPostValue('emergency.relation') : Helper_Main::getValue('emergency.relation', $user_data) ?>">
        </div>
        <div class="group-field-block">
            <label for="emergency_pw">Place of work:</label>
            <input type="text" name="emergency[pw]" id="emergency_pw" value="<?php echo Helper_Main::getPostValue('emergency.pw') ? Helper_Main::getPostValue('emergency.pw') : Helper_Main::getValue('emergency.pw', $user_data) ?>">
            <label for="emergency_to">Tel. Office</label>
            <input type="text" name="emergency[to]" id="emergency_to" value="<?php echo Helper_Main::getPostValue('emergency.to') ? Helper_Main::getPostValue('emergency.to') : Helper_Main::getValue('emergency.to', $user_data) ?>">
        </div>
        <div class="group-field-block">
            <label for="emergency_tm">Mobile</label>
            <input type="text" name="emergency[tm]" id="emergency_tm" value="<?php echo Helper_Main::getPostValue('emergency.tm') ? Helper_Main::getPostValue('emergency.tm') : Helper_Main::getValue('emergency.tm', $user_data) ?>">
            Contacts telephones in case of emergency (give detailed information)
        </div>
        <div class="group-field-block">
            <label for="languages_0">Languages spoken: 1.</label>
            <input type="text" name="languages[0]" id="languages_0" value="<?php echo Helper_Main::getPostValue('languages.0') ? Helper_Main::getPostValue('languages.0') : Helper_Main::getValue('languages.0', $user_data) ?>">
            <label for="languages_1">2.</label>
            <input type="text" name="languages[1]" id="languages_1" value="<?php echo Helper_Main::getPostValue('languages.1') ? Helper_Main::getPostValue('languages.1') : Helper_Main::getValue('languages.1', $user_data) ?>">
            <label for="languages_2">3.</label>
            <input type="text" name="languages[2]" id="languages_2" value="<?php echo Helper_Main::getPostValue('languages.2') ? Helper_Main::getPostValue('languages.2') : Helper_Main::getValue('languages.2', $user_data) ?>">
        </div>
        <div class="field-block">
            <label for="health">Any health conditions that the school should know about: Please specify:</label>
            <input type="text" name="health" id="health" value="<?php echo Helper_Main::getPostValue('health') ? Helper_Main::getPostValue('health') : Helper_Main::getValue('health', $user_data) ?>">
        </div>
    </fieldset>
    
    <fieldset style="margin-top: 20px">
        <legend><strong>Qualification:</strong></legend>
        <div class="qualifications">
        <?php foreach($user_data['qualification'] as $key => $qualification): ?>
            <div class="qualification">
                <div class="group-field-block">
                    <label for="qualification_<?php echo $key ?>_name">Name of Qualification</label>
                    <input type="text" name="qualification[<?php echo $key ?>][name]" id="qualification_<?php echo $key ?>_name" value="<?php echo $qualification['name'] ?>">
                </div>
                <div class="group-field-block">
                    <label for="qualification_<?php echo $key ?>_level">Level (PHD, Masters...)</label>
                    <input type="text" name="qualification[<?php echo $key ?>][level]" id="qualification_<?php echo $key ?>_level" value="<?php echo $qualification['level'] ?>">
                </div>
                <div class="group-field-block">
                    <label for="qualification_<?php echo $key ?>_year">Year of Completion:</label>
                    <input type="text" name="qualification[<?php echo $key ?>][year]" id="qualification_<?php echo $key ?>_year" value="<?php echo $qualification['year'] ?>">
                </div>
                <?php /*
                <div class="group-field-block">
                    <label for="qualification_<?php echo $key ?>_grade">Grade & section</label>
                    <input type="text" name="qualification[<?php echo $key ?>][grade]" id="qualification_<?php echo $key ?>_grade" value="<?php echo $qualification['grade'] ?>">
                    <label for="qualification_<?php echo $key ?>_relation">Relation</label>
                    <input type="text" name="qualification[<?php echo $key ?>][relation]" id="qualification_<?php echo $key ?>_relation" value="<?php echo $qualification['relation'] ?>">
                </div>
                 */ ?>
            </div>
        <?php endforeach; ?>
        </div>
        <a href="#" id="more-qualification"><img src="<?php echo URL::base() ?>img/add_icon.png"></a>
    </fieldset>
    
    <fieldset style="margin-top: 20px">
        <legend><strong>Experience:</strong></legend>
        <div class="experiences">
        <?php foreach($user_data['experience'] as $key => $experience): ?>
            <div class="experience">
                <div class="group-field-block">
                    <label for="experience_<?php echo $key ?>_yfr">Year from:</label>
                    <input type="text" name="experience[<?php echo $key ?>][yfr]" id="experience_<?php echo $key ?>_yfr" value="<?php echo $experience['yfr'] ?>">
                    <label for="experience_<?php echo $key ?>_yto">To:</label>
                    <input type="text" name="experience[<?php echo $key ?>][yto]" id="experience_<?php echo $key ?>_yto" value="<?php echo $experience['yto'] ?>">                    
                </div>                
                <div class="group-field-block">
                    <label for="experience_<?php echo $key ?>_pw">Place of work:</label>
                    <input type="text" name="experience[<?php echo $key ?>][pw]" id="experience_<?php echo $key ?>_pw" value="<?php echo $experience['pw'] ?>">
                </div>
                <div class="group-field-block">
                    <label for="experience_<?php echo $key ?>_job">Job Title:</label>
                    <input type="text" name="experience[<?php echo $key ?>][job]" id="experience_<?php echo $key ?>_job" value="<?php echo $experience['job'] ?>">
                </div>
                <div class="group-field-block">
                    <label for="experience_<?php echo $key ?>_contact">Contact Name (Reference):</label>
                    <input type="text" name="experience[<?php echo $key ?>][contact]" id="experience_<?php echo $key ?>_contact" value="<?php echo $experience['contact'] ?>">
                </div>
                <div class="group-field-block">
                    <label for="experience_<?php echo $key ?>_address">Address:</label>
                    <input type="text" name="experience[<?php echo $key ?>][address]" id="experience_<?php echo $key ?>_address" value="<?php echo $experience['address'] ?>">
                </div>
                <div class="group-field-block">
                    <label for="experience_<?php echo $key ?>_to">Telephone: Office:</label>
                    <input type="text" name="experience[<?php echo $key ?>][to]" id="experience_<?php echo $key ?>_to" value="<?php echo $experience['to'] ?>">
                    <label for="experience_<?php echo $key ?>_tm">Mobile</label>
                    <input type="text" name="experience[<?php echo $key ?>][tm]" id="experience_<?php echo $key ?>_tm" value="<?php echo $experience['tm'] ?>">
                </div>
            </div>
        <?php endforeach; ?>
        </div>
        <a href="#" id="more-experience"><img src="<?php echo URL::base() ?>img/add_icon.png"></a>
    </fieldset>
    <input type="submit" value="Edit teacher">
    <input type="button" style="cursor: pointer" value="Cancel" onclick="javascript: location.href='<?php echo URL::base() ?>teachers/list'">
</form>