function encode() {
    var inputText = document.getElementById('inputText').value;
    var key = parseInt(document.getElementById('key').value);
    var result = cipher(inputText, key);
    document.getElementById('output').textContent = 'Encoded Text: ' + result;
}

function decode() {
    var inputText = document.getElementById('inputText').value;
    var key = parseInt(document.getElementById('key').value);
    var result = cipher(inputText, -key);
    document.getElementById('output').textContent = 'Decoded Text: ' + result;
}

function cipher(text, key) {
    var result = '';
    for (var i = 0; i < text.length; i++) {
        var charCode = text.charCodeAt(i);
        if (charCode >= 65 && charCode <= 90) {
            result += String.fromCharCode(((charCode - 65 + key) % 26 + 26) % 26 + 65);
        } else if (charCode >= 97 && charCode <= 122) {
            result += String.fromCharCode(((charCode - 97 + key) % 26 + 26) % 26 + 97);
        } else {
            result += text.charAt(i);
        }
    }
    return result;
}