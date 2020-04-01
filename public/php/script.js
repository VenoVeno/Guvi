$(document).ready(function () {
    $("#myForm").submit(function (e) {
        var name = $(Uname).val();
        var email = $(Uemail).val();
        var pass1 = $(Opwd).val();
        var dob = $(DOB).val();
        var age = $(Uage).val();
        var mob = $(Unum).val();

        console.log(name, email, pass1);

        $.getJSON('https://secure-scrubland-20144.herokuapp.com/php/Users.json',
            function (data) {
                var addData =
                {
                    [name]:
                    {
                        "name": name,
                        "email": email,
                        "Opwd": pass1,
                        "dob": dob,
                        "age": age,
                        "contact": mob
                    }
                };
                $.extend(true, data, addData);

                console.log('GET COMPLETE', addData, data);

                var newData = JSON.stringify(data);
                jQuery.post('https://secure-scrubland-20144.herokuapp.com/php/writejson.php', { newData: newData });

                console.log('SAVE COMPLETE');
            });
        $.ajax({
            url: 'https://secure-scrubland-20144.herokuapp.com/php/echo.php',
            type: 'POST',
            data: {
                Uname: name,
                Uemail: email,
                Opwd: pass1,
                dob: dob,
                age: age,
                contact: mob
            },
            success: function (data) {
                console.log(data);
                window.location.href = "https://secure-scrubland-20144.herokuapp.com/login.html";
            },
            error: function (error) {
                console.log(error);
            }
        });
        e.preventDefault();
    });
});

$(document).ready(function () {
    $("#LogForm").submit(function (e) {
        var email_name = $(Uname_email).val();
        var password = $(Upwd).val();
        var safename;
        var jflag = 0, dflag = 0;

        console.log(email_name, password);
        e.preventDefault();

        $('#loginerror').html(" ");

        console.log("Success outside", jflag);

        console.log("Success before JSON");

        $.getJSON("https://secure-scrubland-20144.herokuapp.com/php/Users.json",
            function (data) {
                console.log("Success inside JSON", jflag);
                try {
                    $.each(data, function (index, details) {
                        if (data[index].name == email_name || data[index].email == email_name) {
                            if (data[index].Opwd == password) {
                                safename = data[index].name;
                                console.log("Success before Flag", jflag);
                                jflag = 1;
                                console.log("Success after Flag", jflag);
                            }
                        }
                    });
                    e.preventDefault();
                }
                catch (err) {
                    console.log("Error in JSON" + err);
                }
            });

        console.log("Success after JSON", jflag);

        console.log("Success before Ajax", jflag);

        $.ajax({
            url: "https://secure-scrubland-20144.herokuapp.com/php/login.php",
            type: 'POST',
            data:
            {
                Uemail_name: email_name,
                Upwd: password
            },
            success: function (data) {
                console.log(data);
                dflag = 1;
                console.log(dflag, jflag);
                if (jflag == 1 && dflag == 1) {
                    if (typeof (Storage) !== undefined) {
                        sessionStorage.setItem("username", safename);
                        window.location.href = "https://secure-scrubland-20144.herokuapp.com/Profile.html";
                    }
                }
                else if (jflag == 0 || dflag == 0)
                    $('#loginerror').html("Invalid Username/Password");
            }
        });
    });
});

$(document).ready(function () {
    $("#Pform").submit(function (e) {
        e.preventDefault();
        var checkflag, nochangeflag;
        var name = $(Uname).val();
        var dob = $(DOB).val();
        var mob = $(Unum).val();

        var age = calculateage(dob).toString();

        console.log(age, mob);

        $.getJSON('https://secure-scrubland-20144.herokuapp.com/php/Users.json', function (data) {
            try {
                nochangeflag = 0;
                checkflag = 0;
                $.each(data, function (index, details) {
                    console.log("Fetch Success", data);

                    if (data[index].name == name) {
                        checkflag = 1;
                        console.log(checkflag);
                        console.log(data[index].dob, data[index].age, data[index].contact);

                        if (data[index].dob == dob && data[index].age == age && data[index].contact == mob) {
                            nochangeflag = 1;
                        }
                        if (nochangeflag == 0) {
                            data[index].dob = dob;
                            data[index].age = age;
                            data[index].contact = mob;
                            console.log("Edit Success");
                        }
                        else {
                            console.log("No data is modified")
                        }
                    }
                });
                if (!nochangeflag && checkflag) {
                    var newData = JSON.stringify(data);

                    jQuery.post('https://secure-scrubland-20144.herokuapp.com/php/writejson.php', { newData: newData });
                    console.log('SAVE COMPLETE');
                }
            }
            catch (err) {
                console.log("Error" + err);
            }
        });

        $.ajax({
            url: 'https://secure-scrubland-20144.herokuapp.com/php/modify.php',
            type: 'POST',
            data: {
                Uname: name,
                dob: dob,
                age: age,
                contact: mob
            },
            success: function (data) {
                window.onload();
                console.log(data);
            }
        });
        window.onload();
    });
});

$(document).ready(function () {
    $("#Pform").submit(function (e) {

    });
});

function checkSession() {
    if (typeof (Storage) !== undefined) {
        if (sessionStorage.getItem("username")) {
            alert("Taking You to The Profile");
            window.location = "https://secure-scrubland-20144.herokuapp.com/Profile.html";
        }
    }
}

function validateSession() {
    if (typeof (Storage) !== undefined) {
        if (!sessionStorage.getItem("username")) {
            alert("Your Session has been expired! Try Login Again!");
            window.location = "https://secure-scrubland-20144.herokuapp.com/login.html";
        }
    }
}

function display() {
    if (typeof (Storage) !== undefined) {
        var name = sessionStorage.getItem("username");
        if (name) {
            console.log("hey")
            $.ajax({
                url: 'https://secure-scrubland-20144.herokuapp.com/php/profile.php',
                type: 'POST',
                data: { Uname: name },
                success: function (row) {
                    console.log("hey Hi Jerry")
                    $('#dynBody').html(row);
                }
            });
        }
        else {
            alert("Your Session has been expired! Try Login Again!");
            window.location = "https://secure-scrubland-20144.herokuapp.com/login.html";
        }
    }
}

function logoutUser() {
    sessionStorage.removeItem('username');
    alert("You have been Successfully logged Out!");
    window.location = "https://secure-scrubland-20144.herokuapp.com/login.html";
}

function calculateage(dob) {
    var birthdate = new Date(dob);
    var cur = new Date();
    var diff = cur - birthdate;
    var age = Math.floor(diff / 31536000000);
    return age;
}