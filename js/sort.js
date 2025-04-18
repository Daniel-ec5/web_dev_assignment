 document.getElementById("sort").addEventListener("change", function () {
    const sortValue = this.value;
    if (sortValue) {
      window.location.href = `viewblog.php?sort=${sortValue}`;
    }
  });