<?php if(!empty($errors)): ?>
    <div class="error">
        <?php foreach($errors as $error): ?>
            <p><?php echo $error ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<form class="form-registrate" name="admin_new" action="<?php echo URL::base() ?>admins/new" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="status" value="1">
    <fieldset>
        <div class="group-field-block">
            <label for="role"><strong>Role</strong></label>
            <select name="role" id="role">
                <option value="admin" <?php echo Helper_Main::getPostValue('role') == 'admin' ? 'selected' : '' ?>>Admin</option>
                <option value="sadmin" <?php echo Helper_Main::getPostValue('role') == 'sadmin' ? 'selected' : '' ?>>Super admin</option>
            </select>
        </div>
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
    <input type="submit" value="Create admin">
</form>