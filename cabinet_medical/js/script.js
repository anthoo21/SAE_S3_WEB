function print() {
    var frame = document.getElementById('frame');
    frame.contentWindow.focus();
    frame.contentWindow.print();
}