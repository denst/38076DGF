<?php if(!empty($success)): ?>
    <div class="success">
        <p><?php echo $success ?></p>
    </div>
<?php endif; ?>
<form class="form-registrate" name="admin_edit" action="<?php echo URL::base() ?>admins/edit/<?php echo $user->id ?>" method="POST" enctype="multipart/form-data">
    <fieldset>
        <div class="group-field-block">
            <label for="role"><strong>Role</strong></label>
            <select name="role" id="role">
                <?php $role = Helper_Main::getPostValue('role') ? Helper_Main::getPostValue('role') : $role ?>
                <option value="admin" <?php echo $role == 'admin' ? 'selected' : '' ?>>Admin</option>
                <option value="sadmin" <?php echo $role == 'sadmin' ? 'selected' : '' ?>>Super admin</option>
            </select>
        </div>
        <div class="group-field-block">
            <label for="name">Name(it will be username for login system)</label>
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
    <input type="submit" value="Edit admin">
    <input type="button" style="cursor: pointer" value="Cancel" onclick="javascript: location.href='<?php echo URL::base() ?>admins/list'">
</form>