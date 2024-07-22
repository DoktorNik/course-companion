function validateCourseFeedback() {

    let errorInitial = '<b>Please complete the course feedback!</b><br/>';
    let error = errorInitial;

    // check lecturer
    let lecturer = document.getElementById('lecturer');
    console.log(lecturer.value);
    if (lecturer.value === "")
        error += '<br/>Please enter the name of the lecturer.';

    // check the ranking elements for completion
    if (!isSet('difficulty'))
        error += '<br/>Please select the difficulty level of this course.';
    if (!isSet('workload'))
        error += '<br/>Please select the workload required by this course.';
    if (!isSet('clarity'))
        error += '<br/>Please select how clear this course is.';
    if (!isSet('relevance'))
        error += '<br/>Please select how relevant this course is.';
    if (!isSet('interest'))
        error += '<br/>Please select how interesting this course is.';
    if (!isSet('helpfulness'))
        error += '<br/>Please select helpful this course is.';
    if (!isSet('experiential'))
        error += '<br/>Please select how much experience you gained while taking this course.';
    if (!isSet('affect'))
        error += '<br/>Please select how positive you felt during this course.';


    // submit if the form is complete
    let errorDiv = document.getElementById('errorList');
    if (error === errorInitial) {
        // clear error and submit
        errorDiv.innerHTML = '';
        errorDiv.style.display = "none";

        // submit
        document.getElementById('courseFeedbackForm').submit();
    }
    // otherwise, show errors
    else {
        errorDiv.innerHTML = error;
        errorDiv.style.display = "block";
    }
}
window.validateCourseFeedback = validateCourseFeedback;

function isSet(elementName) {

    // go through all 5 of these to see if any are checked
    for (let i = 1; i <= 5; i++) {
        let ele = document.getElementById(elementName + i);

        // huzzah, checked
        if (ele.checked)
            return true;
    }

    // never checked :(
    return false;
}

// select the button
function setRating(elementName, number) {
    let name = elementName + number;
    let ele = document.getElementById(name);
    ele.checked = true;
}
window.setRating = setRating;
