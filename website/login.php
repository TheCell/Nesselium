<?php
// must be first statement
require_once '../include/includeHeader.php';

?>
<script src="../js/sha512.js"></script>
<script>
function hashPW(form, nameOrEmail, password)
{
    // Check each field has a value
    if ( nameOrEmail.value == '' || password.value == '') 
    {
        alert('You must provide all the requested details. Please try again');
        return false;
    }

    var hashedPW = document.createElement("input");
    form.appendChild(hashedPW);
    
    hashedPW.name = "hashedPassword";
    hashedPW.type = "hidden";
    hashedPW.value = hex_sha512(password.value);
    password.value = '';
    
    // Finally submit the form. 
    form.submit();
    return true;
}
</script>
<form action="loginform.php" method="POST">
    <fieldset>
        <legend>Login</legend>
        <input type="text" name="nameOrEmail" id="nameOrEmail" placeholder="Name or Email"><!-- TODO: translate-->
        <input type="password" name="password" id="password" placeholder="Password"><!-- TODO: translate-->
        <input type="button" value="Submit" onclick="return hashPW(this.form, this.form.nameOrEmail, this.form.password);">
    </fieldset>
</form>
<?php
// must be last statement
require_once '../include/includeFooter.php';
?>