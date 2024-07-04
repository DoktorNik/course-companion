// function test() {
//     alert('test');
// }
//
// window.test = test;
// alert('loaded');

function updateArray(add)    {
    let target = document.getElementById('txtToken').value.trim();
    let text = document.getElementById('taArray').value.trim();

    // add the course to the list
    if (add === 1) {
        if (target === "")
            console.log("Cannot add blank entry!");
        else if(text.indexOf(target) > -1)
            console.log("Skipping duplicate entry!");
        else {
            if (text !== "")
                text += ", ";
            text += target;
        }
    }
    // remove the course from the list
    else {
        if (target === "")
            console.log("Cannot remove blank entry");
        else {
            // check if found
            if (text.indexOf(target) === -1)
                console.log("Entry not found");
            else {
                // remove with a preceding comma
                if (text.indexOf(", " + target) > -1)
                    text = text.replace(", " + target, "");
                // remove without preceding comma
                else {
                    // if this is the first listing
                    if (text.indexOf(target) === 0) {
                        // if there's a proceeding comma, remove it
                        if (text.indexOf(target + ", ") > -1)
                            text = text.replace(target + ", ", "")
                        // otherwise remove the listing itself
                        else
                            text = text.replace(target, "");
                    } else
                        console.log("ERROR: no preceding comma and not first listing!")
                }
            }
        }
    }

    document.getElementById('taArray').innerHTML = text;
    document.getElementById('txtToken').value = '';
}
window.updateArray = updateArray;
