function search() {
  ///search function
  const searchValue = $("#seachBar").val().toUpperCase();
  const userRows = $(".userRow");

  for (var i = 0; i < userRows.length; i++) {
    let match = $(userRows[i]).find("td");
    // console.log(match);
    if (match) {
      let textValue = match.text().toUpperCase();
      if (textValue.indexOf(searchValue) > -1) {
        $(userRows[i]).show();
      } else {
        $(userRows[i]).hide();
      }
    }
  }
}
