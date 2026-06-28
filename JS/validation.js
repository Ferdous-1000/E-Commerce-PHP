function validateSignup()
{
    let name =
    document.getElementById("name").value;

    let email =
    document.getElementById("email").value;

    let username =
    document.getElementById("username").value;

    let password =
    document.getElementById("password").value;

    if(
        name=="" ||
        email=="" ||
        username=="" ||
        password==""
    )
    {
        alert(
            "All fields are required"
        );

        return false;
    }

    return true;
}