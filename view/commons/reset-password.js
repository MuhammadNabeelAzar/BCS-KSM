function resetPassword(userID, event) {
  event.preventDefault();
  const current_password = $("#currentPassword").val();
  const new_password = $("#newPassword").val();
  const confirm_password = $("#confirmPassword").val();

  if (new_password !== confirm_password) {
    $(".password-match-status").html("New passwords do not match.").css({
      color: "red",
      "font-size": "14px",
    });
    return false;
  }
  //verify current password
  $.ajax({
    type: "POST",
    url: "../../controller/user_controller.php?status=verify-password",
    data: { user_id: userID, current_password: current_password },
    dataType: "JSON",
    success: function (response) {
      if (response === true) {

        $.ajax({
          type: "POST",
          url: "../../controller/user_controller.php?status=reset-password",
          data: { user_id: userID, new_password: new_password },
          dataType: "JSON",
          success: function (response) {
            $("#currentPassword").val('');
            $("#newPassword").val('');
            $("#confirmPassword").val('');
            $("#password-strength-status").text('')
            Swal.fire(response);
          },
        });
      } else {
        $(".password-match-status").html("Current password doesnt match !").css({
            color: "red",
            "font-size": "14px",
          });
          return false;
      }
    },
  });
}

function checkPasswordStrength() {
  var number = /([0-9])/;
  var alphabets = /([a-zA-Z])/;
  var special_characters = /([~,!,@,#,$,%,^,&,*,-,_,+,=,?,>,<])/;
  const password = $("#newPassword").val().trim();

  if (password.length < 6) {
    $("#password-strength-status").removeClass();
    $("#password-strength-status").addClass("weak-password");
    $("#password-strength-status").html(
      "Weak (should be atleast 6 characters.)"
    );
  } else {
    if (
      password.match(number) &&
      password.match(alphabets) &&
      password.match(special_characters)
    ) {
      $("#password-strength-status").removeClass();
      $("#password-strength-status").addClass("strong-password");
      $("#password-strength-status").html("Strong");
    } else {
      $("#password-strength-status").removeClass();
      $("#password-strength-status").addClass("medium-password");
      $("#password-strength-status").html(
        "Medium (should include alphabets, numbers and special characters.)"
      );
    }
  }
}
