<?php
function validate($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function is_array_empty($tags)
{
    if (is_array($tags)) {
        foreach ($tags as $key => $value) {
            if (!empty($value) || $value != NULL || $value != "") {
                return true;
            }
            break;
            //since at least one tag has value, close the loop
        }
        return false;
    }
}
?>