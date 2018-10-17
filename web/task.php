<?php
echo electionWinner(['Alex', 'Michael', 'Harry', 'Dave', 'Michael', 'Victor', 'Harry', 'Alex', 'Mary', 'Mary']);

function electionWinner($votes)
{
    $candidatesVotes = [];
    foreach ($votes as $vote) {
        if (!array_key_exists($vote, $candidatesVotes)) {
            $candidatesVotes[$vote] = 1;
        } else {
            $candidatesVotes[$vote] = $candidatesVotes[$vote] + 1;
        }
    }
    $maxValueInArray = 0;
    $winner = '';
    foreach ($candidatesVotes as $name => $votes) {
        if ($votes > $maxValueInArray) {
            $maxValueInArray = $votes;
            $winner = $name;
        } else if ($votes == $candidatesVotes &&
            strcasecmp($winner, $name) > 0) {
            $winner = $name;
        }
    }
    return $name;
}
exit;
