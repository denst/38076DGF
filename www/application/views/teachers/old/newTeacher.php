<?php if(!empty($errors)): ?>
    <div class="error">
        <?php foreach($errors as $error): ?>
            <p><?php echo $error ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<form class="form-registrate" name="teacher_new" action="<?php echo URL::base() ?>teachers/new" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="status" value="1">
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
            <label for="grfathername">Grand Father's Name</label>
            <input type="text" name="grfathername" id="grfathername" value="<?php echo Helper_Main::getPostValue('grfathername') ?>">
        </div>
        <div class="group-field-block">
            <label for="password">Password</label>
            <input type="password" name="password" id="password">
        </div>
        <div class="group-field-block">
            <label for="password_confirm">Confirm password</label>
            <input type="password" name="password_confirm" id="password_confirm">
        </div>
    </fieldset>
    
    <fieldset style="margin-top: 20px">
        <div class="group-field-block">
            <label for="image">Photo</label>
            <input type="file" name="image" id="image">
        </div>
    </fieldset>
    
    <fieldset style="margin-top: 20px">
        <div class="group-field-block">
            <label for="dob">Date of birth (E.C) </label>
            <input type="text" name="dob" id="dob" value="<?php echo Helper_Main::getPostValue('dob') ? Helper_Main::getPostValue('dob') : '' ?>">
            <label for="sex">Sex</label>
            <select name="sex" id="sex">
                <option value="0" <?php echo Helper_Main::getPostValue('sex') == '0' ? 'selected': '' ?>>Male</option>
                <option value="1" <?php echo Helper_Main::getPostValue('sex') == '1' ? 'selected': '' ?>>Female</option>
            </select>
        </div>
        <div class="group-field-block">
            <label for="address_kk">Home Address: Kifle Ketema</label>
            <input type="text" name="home_address[kk]" id="address_kk" value="<?php echo Helper_Main::getPostValue('home_address.kk') ?>">
            <label for="address_k">Kebele</label>
            <input type="text" name="home_address[k]" id="address_k" value="<?php echo Helper_Main::getPostValue('home_address.k') ?>">
            <label for="address_h">House No.</label>
            <input type="text" name="home_address[h]" id="address_h" value="<?php echo Helper_Main::getPostValue('home_address.h') ?>">
        </div>
        <div class="group-field-block">
            <label for="lpw">Last Place of work:</label>
            <input type="text" name="lpw" id="lpw" value="<?php echo Helper_Main::getPostValue('lpw') ?>">
        </div>
        <div class="group-field-block">
            <label for="job">Job Title:</label>
            <input type="text" name="job" id="job" value="<?php echo Helper_Main::getPostValue('job') ?>">
        </div>
        <div class="group-field-block">
            <label for="contact_name">Contact Name (Reference):</label>
            <input type="text" name="contact_name" id="contact_name" value="<?php echo Helper_Main::getPostValue('contact_name') ?>">
        </div>
        <div class="group-field-block">
            <label for="address">Address:</label>
            <input type="text" name="address" id="address" value="<?php echo Helper_Main::getPostValue('address') ?>">
        </div>
        <div class="group-field-block">
            <label for="telephone_of">Telephone: Office:</label>
            <input type="text" name="telephone[of]" id="telephone_of" value="<?php echo Helper_Main::getPostValue('telephone.of') ?>">
            <label for="telephone_m">Mobile</label>
            <input type="text" name="telephone[m]" id="telephone_m" value="<?php echo Helper_Main::getPostValue('telephone.m') ?>">
        </div>
    </fieldset>
    
    <fieldset style="margin-top: 20px">
        <div class="group-field-block">
            <label for="emergency_contact">Emergency Contact:</label>
            <input type="text" name="emergency[contact]" id="emergency_contact" value="<?php echo Helper_Main::getPostValue('emergency.contact') ?>">
        </div>
        <div class="group-field-block">
            <label for="emergency_relation">Relation to you:</label>
            <input type="text" name="emergency[relation]" id="emergency_relation" value="<?php echo Helper_Main::getPostValue('emergency.relation') ?>">
        </div>
        <div class="group-field-block">
            <label for="emergency_pw">Place of work:</label>
            <input type="text" name="emergency[pw]" id="emergency_pw" value="<?php echo Helper_Main::getPostValue('emergency.pw') ?>">
            <label for="emergency_to">Tel. Office</label>
            <input type="text" name="emergency[to]" id="emergency_to" value="<?php echo Helper_Main::getPostValue('emergency.to') ?>">
        </div>
        <div class="group-field-block">
            <label for="emergency_tm">Mobile</label>
            <input type="text" name="emergency[tm]" id="emergency_tm" value="<?php echo Helper_Main::getPostValue('emergency.tm') ?>">
            Contacts telephones in case of emergency (give detailed information)
        </div>
        <div class="group-field-block">
            <label for="languages_0">Languages spoken: 1.</label>
            <input type="text" name="languages[0]" id="languages_0" value="<?php echo Helper_Main::getPostValue('languages.0') ?>">
            <label for="languages_1">2.</label>
            <input type="text" name="languages[1]" id="languages_1" value="<?php echo Helper_Main::getPostValue('languages.1') ?>">
            <label for="languages_2">3.</label>
            <input type="text" name="languages[2]" id="languages_2" value="<?php echo Helper_Main::getPostValue('languages.2') ?>">
        </div>
        <div class="field-block">
            <label for="health">Any health conditions that the school should know about: Please specify:</label>
            <input type="text" name="health" id="health" value="<?php echo Helper_Main::getPostValue('health') ?>">
        </div>
    </fieldset>
    
    <fieldset style="margin-top: 20px">
        <legend><strong>Qualification:</strong></legend>
        <div class="qualifications">
            <div class="qualification">
                <div class="group-field-block">
                    <label for="qualification_0_name">Name of Qualification</label>
                    <input type="text" name="qualification[0][name]" id="qualification_0_name" value="<?php echo Helper_Main::getPostValue('qualification.0.name') ?>">
                </div>
                <div class="group-field-block">
                    <label for="qualification_0_level">Level (PHD, Masters...)</label>
                    <input type="text" name="qualification[0][level]" id="qualification_0_level" value="<?php echo Helper_Main::getPostValue('qualification.0.level') ?>">
                </div>
                <div class="group-field-block">
                    <label for="qualification_0_year">Year of Completion:</label>
                    <input type="text" name="qualification[0][year]" id="qualification_0_year" value="<?php echo Helper_Main::getPostValue('qualification.0.year') ?>">
                </div>
                <?php /*
                <div class="group-field-block">
                    <label for="qualification_0_grade">Grade & section</label>
                    <input type="text" name="qualification[0][grade]" id="qualification_0_grade" value="<?php echo Helper_Main::getPostValue('qualification.0.grade') ?>">
                    <label for="qualification_0_relation">Relation</label>
                    <input type="text" name="qualification[0][relation]" id="qualification_0_relation" value="<?php echo Helper_Main::getPostValue('qualification.0.relation') ?>">
                </div>
                */ ?>
            </div>
        </div>
        <a href="#" id="more-qualification"><img src="<?php echo URL::base() ?>img/add_icon.png"></a>
    </fieldset>
    
    <fieldset style="margin-top: 20px">
        <legend><strong>Experience:</strong></legend>
        <div class="experiences">
            <div class="experience">
                <div class="group-field-block">
                    <label for="experience_0_yfr">Year from:</label>
                    <input type="text" name="experience[0][yfr]" id="experience_0_yfr" value="<?php echo Helper_Main::getPostValue('experience.0.yfr') ?>">
                    <label for="experience_0_yto">To:</label>
                    <input type="text" name="experience[0][yto]" id="experience_0_yto" value="<?php echo Helper_Main::getPostValue('experience.0.yto') ?>">
                </div>
                <div class="group-field-block">
                    <label for="experience_0_pw">Place of work:</label>
                    <input type="text" name="experience[0][pw]" id="experience_0_pw" value="<?php echo Helper_Main::getPostValue('experience.0.pw') ?>">
                </div>
                <div class="group-field-block">
                    <label for="experience_0_job">Job Title:</label>
                    <input type="text" name="experience[0][job]" id="experience_0_job" value="<?php echo Helper_Main::getPostValue('experience.0.job') ?>">
                </div>
                <div class="group-field-block">
                    <label for="experience_0_contact">Contact Name (Reference):</label>
                    <input type="text" name="experience[0][contact]" id="experience_0_contact" value="<?php echo Helper_Main::getPostValue('experience.0.contact') ?>">
                </div>
                <div class="group-field-block">
                    <label for="experience_0_address">Address:</label>
                    <input type="text" name="experience[0][address]" id="experience_0_address" value="<?php echo Helper_Main::getPostValue('experience.0.address') ?>">
                </div>
                <div class="group-field-block">
                    <label for="experience_0_to">Telephone: Office:</label>
                    <input type="text" name="experience[0][to]" id="experience_0_to" value="<?php echo Helper_Main::getPostValue('experience.0.to') ?>">
                    <label for="experience_0_tm">Mobile</label>
                    <input type="text" name="experience[0][tm]" id="experience_0_tm" value="<?php echo Helper_Main::getPostValue('experience.0.tm') ?>">
                </div>
            </div>
        </div>
        <a href="#" id="more-experience"><img src="<?php echo URL::base() ?>img/add_icon.png"></a>
    </fieldset>
    <input type="submit" value="Create teacher">
</form>