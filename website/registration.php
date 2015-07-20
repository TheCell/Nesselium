<?php
require_once '../include/includeHeader.php';
?>

<script type="text/JavaScript" src="../js/forms.js"></script>

<?php
require_once 'registrationForm.php';
/*
 * output Errors from the registration
 */
if (isset($error_msg))
{
    echo $error_msg;
}

?>
<h1>Register here</h1>
<ul>
    <li>Usernames may contain only digits, upper and lower case letters and underscores</li>
    <li>Emails must have a valid email format</li>
    <li>Passwords must be at least 6 characters long</li>
    <li>Passwords must contain
        <ul>
            <li>At least one uppercase letter (A..Z)</li>
            <li>At least one lower case letter (a..z)</li>
            <li>At least one number (0..9)</li>
        </ul>
    </li>
    <li>Your password and confirmation must match exactly</li>
</ul>
<?php

/*
 * TODO: pattern Specifies a regular expression to check the input value against
 * it is possible to use regular expressions in html5 form
 * wait for it to be available in the browsers
 * 
 * disabled 	Specifies that an input field should be disabled
    max 	Specifies the maximum value for an input field
    maxlength 	Specifies the maximum number of character for an input field
    min 	Specifies the minimum value for an input field
    pattern 	Specifies a regular expression to check the input value against
    readonly 	Specifies that an input field is read only (cannot be changed)
    required 	Specifies that an input field is required (must be filled out)
    size 	Specifies the width (in characters) of an input field
    step 	Specifies the legal number intervals for an input field
    value 	Specifies the default value for an input field
 */

$stringvalidator = new Stringvalidator;

?>
<form action="<?php echo $stringvalidator->esc_url($_SERVER['PHP_SELF']); ?>"
    method="post" 
    name="registration_form">
    <fieldset>
        <legend>Registration</legend>
    Username*: <input type='text'
                     name='username'
                     id='username' 
                     required /><br />
    E-Mail*: <input type='text'
                   name='email'
                   id='email' 
                   placeholder='example@domain.ch'
                   required /><br />
    Firstname: <input type='text' 
                    name='firstname' 
                    id='firstname' /><br />
    Lastname: <input type='text' name='lastname' id='lastname' /><br />
    Birthdate: <input type='date' name='birthdate' id='birthdate'
                      placeholder='dd.mm.jjjj'>
    Password*: <input type='password' 
                    name='password' 
                    id="password"
                    required /><br />
    Confirm password*: <input type='password' 
                            name='confirmpwd' 
                            id='confirmpwd' 
                            required /><br />
    Language: <select name="language"
                      id="language">
        <?php
            $dbcon = new Database();
            $sqlQueryString = "SELECT languageName, PK_language FROM tbllanguage";
            $languages = $dbcon->getInfo($sqlQueryString);

            if (isset($languages))
            {
                for ($i = 0; $i < sizeof($languages); $i++) 
                {
                    echo '<option value="' . $languages[$i]['PK_language'] . '">' . $languages[$i]['languageName'] . '</option>';
                }
            }
        ?>
    </select>
    <input type="button" 
        value="Register" 
        onclick="return regformhash(this.form,
                    this.form.username,
                    this.form.email,
                    this.form.firstname,
                    this.form.lastname,
                    this.form.birthdate,
                    this.form.password,
                    this.form.confirmpwd,
                    this.form.language);" /> 
    </fieldset>
</form>
<?php
if (isset($_GET['error']))
{
    $stringvalidator = new Stringvalidator();
    echo '<p class=error>';
    echo $stringvalidator->cleanXSS($_GET['error']);
    echo '</p>';
}
?>
<p>Return to the <a href="index.php">login page</a>.</p>
<?php
require_once '../include/includeFooter.php';
?>