export { cutText };

function cutText(text, length) {
    if (text.length < length) return text;

    text = text.substring(0, length);

    if (text.substring(text.length - 1) === " ") {
        text = text.substring(0, text.length - 1);
    }
        
    if (text.substring(text.length -1) === ".") {
        text = text.substring(0, text.length - 1);
    }

    return text + "...";
}

