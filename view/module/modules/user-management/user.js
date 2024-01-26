function search() {
  const searchValue = $("#seachBar").val().toUpperCase();
  const table = $(".table");
  const userRows = $(".userRow");

  for (var i = 0; i < userRows.length; i++) {
    let match = $(userRows[i]).find("td");
    // console.log(match);
    if (match) {
      let textValue = match.text().toUpperCase();
      console.log(textValue);
      if (textValue.indexOf(searchValue) > -1) {
        console.log("works");
        $(userRows[i]).show();
      } else {
        $(userRows[i]).hide();
      }
    }
  }
}
