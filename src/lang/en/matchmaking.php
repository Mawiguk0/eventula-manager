<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Matchmaking Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */
    'ispublic' => 'is public (show match publicly for signup)',
    'ended' => 'has ended',
    'live' => 'is live',
    'draft' => 'draft',
    'pending' => 'is pending',
    'waitforplayers' => 'Waiting for players',
    'match' => 'Match',
    'matchmaking' => 'Matchmaking',
    'matchowner' => 'Match owner',
    'notsignedup' => 'Not signed up',
    'ownedmatches' => 'Your owned matches',
    'ownedteams' => 'Matches with teams of which you are joined',
    'publicmatches' => 'Open public matches',
    'closedpublicmatches' => 'Live/Closed public matches',
    'signedup' => 'Signed up',
    'signupsclosed' => 'Signups closed',
    'teamcount' => 'Team count',
    'teamowner' => 'Team owner',
    'teamsizes' => 'Team sizes',
    'game' => 'Game',
    'add' => 'Add',
    'addteam' => 'Add team',
    'addmatch' => 'Add match',
    'currentstatus' => 'Current status:',
    'deletematch' => 'Delete match',
    'deleteteam' => 'Delete team',
    'doyouwanttojointeam' => 'Do you want to join the following Team? :',
    'editteam' => 'Edit team',
    'finalizematch' => 'Finalize match',
    'inviteurl' => 'Invitation link',
    'jointeam' => 'Join team',
    'switchteam' => 'Switch to team',
    'successfullychangedteamplayer' => 'sucessfully switched the team!',
    'matchinviteurl' => 'Match invitation link',
    'name' => 'Name',
    'openmatch' => 'Open match',
    'removefrommatch' => 'Remove from match',
    'leavematch' => 'Leave match',
    'score' => 'Score',
    'startmatch' => 'Start match',
    'submit' => 'Submit',
    'team' => 'Team',
    'user' => 'User',
    'editmatch' => 'Edit Match',
    'firstteamname' => 'Team 1 Name',
    'teamsize' => 'Team size',
    'teamcounts' => 'Team count',
    'teamname' => 'Team Name',
    'games' => 'Game',
    'scoreof' =>'Score of',
    'thisisyourteam' => 'This is your team!',
    'nopermissions' => 'You have no access to this Match! You need either an invite link from a match owner or a team owner or the match owner must set the match to public!',
    'matchmakinghome' => 'Click here to find other matches.',
    'maxopened' => 'You have already more opened matches than allowed. Please finalize your matches first!',
    'error' => 'Error',


    'team_size_required'    => 'Team size is required',
    'team_size_mustbeoneof'    => 'Team size must be one of: 1v1,2v2,3v3,4v4,5v5,6v6',
    'team_count_required'    => 'Team Count is required',
    'team_count_integer'    => 'Team size must be an integer',
    'teamname_required'    => 'Team name is required',
    'teamcount_smallerthangamesmin' => 'teamcount smaller than selected games minimal teamcount! Min is ',
    'teamcount_biggerthangamesmax' => 'teamcount bigger than selected games maximal teamcount! Max is ',
    'cannotcreatematch' => 'Cannot create match!',
    'cannotcreatteambutcannotdeletematch' => 'Cannot create Team 1 but cannot delete match! broken database entry!',
    'cannotcreateteam1' => 'Cannot create Team 1! Match not created!',
    'cannotcreateteamplayer1butcannotdeleteteam' => 'Cannot create teamplayer 1 but cannot delete team! broken database entry!',
    'cannotcreateteamplayer1butcannotdeletematch' => 'Cannot create teamplayer 1 but cannot delete Match! broken database entry!',
    'cannotcreateteamplayer1' => 'Cannot create teamplayer 1! Match and team not created!',
    'successfullycreatedmatch' => 'Successfully created match!',
    'cannotupdatematchnotowner' => 'Cannot update Match because you are not the owner!',
    'cannotupdatematchstatus' => 'you cannot update a match while it is live or complete!',
    'tomanyplayersforteamsize' => 'at least one team has to many players for this team size!',
    'cannotupdatematch' => 'Cannot update match!',
    'successfullyupdatedmatch' => 'Successfully updated match!',
    'cannotaddteamstatus' => 'you cannot add a team while the match is live or complete!',
    'cannotaddteamcount' => 'no more teams could be added because of the team count limit!',
    'youalreadyareinateam' => 'can not add team because you are already member of a team!',
    'cannotcreateteam' => 'Cannot create Team !',
    'cannotcreateteamplayerforowner' => 'Cannot create teamplayer for team owner!',
    'successfullyaddedteam' => 'Successfully added team!',
    'cannotupdateteamnotowner' => 'Cannot update team because you are not the owner!',
    'cannotupdateteamstatus' => 'you cannot update a team while the match is live or complete!',
    'cannotsaveteam' => 'Cannot save Team !',
    'successfullyupdatedteam' => 'Successfully updated team!',
    'cannotdeleteteamstatus' => 'you cannot delete a team while the match is live or complete!',
    'cannotdeleteinitialteam' => 'you cannot delete the initial team!',
    'cannotdeleteteamplayers' => 'Cannot delete teamplayers!',
    'cannotdeleteteam' => 'Cannot delete team!',
    'deletedteam' => 'deleted team!',
    'cannnotjoinstatus'=> 'you cannot join to the team while the match is live or complete!',
    'cannotjoinalreadyfull' => 'Team is already full!',
    'cannotcreateteamplayer' => 'Cannot create teamplayer!',
    'successfiullyaddedteamplayer' => 'Successfully joined team!',
    'cannotleavestatus' => 'you cannot leave the team while the match is live or complete!',
    'cannotdeleteteamplayer' => 'Cannot delete Teamplayer!',
    'successfullydeletedteamplayer' => 'Successfully deleted Teamplayer!',
    'cannotdeletematchnotowner' => 'Cannot delete Match because you are not the owner!',
    'cannotdeleteplayers' => 'Cannot delete Players!',
    'cannotdeleteteams' => 'Cannot delete Teams!',
    'cannotdeletereplays' => 'Cannot delete Replays!',
    'cannotdeletereplayfiles' => 'Cannot delete Replay files!',
    'cannotdeletematch' => 'Cannot delete Match!',
    'successfullydeletedmatch' => 'Successfully deleted Match!',
    'cannotstartmatchnotowner' => 'Cannot start Match because you are not the owner!',
    'matchalreadystartedorcompleted' => 'Match is already live or completed',
    'notallrequiredteamsarethere' => 'Not all required teams are there',
    'notenoughplayerstostart' => 'at least one team has not enough players to start the match !',
    'cannotstartmatch' => 'Cannot start Match!',
    'matchstarted' => 'Match Started!',
    'matchpending' => 'Match start was requested, an administrator has to approve it!',
    'cannotopenmatchnotowner' => 'Cannot open Match because you are not the owner!',
    'matchalreadyopenliveorcompleted' => 'Match is already open/ live or completed',
    'cannotopenmatch' => 'Cannot open Match!',
    'matchopened' => 'Match Opened!',
    'cannotfinalizenotowner' => 'Cannot finalize Match because you are not the owner!',
    'missingscoreforteam' => 'for at least one team no score was specified',
    'scorecouldnotbesetted' => 'Score for at least one team could not be setted!',
    'cannotfinalize' => 'Cannot finalize. Match is still live!',
    'matchfinalized' => 'Match Finalized!',
    'invitationnotfound' => 'Invitation not found!',
    'pleaselogin' => 'Please Login.',
    'cannotjoinyoualreadyareinateam' => 'You can not join the team because you are already member of a team!',
    'scramble' => 'Scramble Teams',
    'cannotjointhirdparty' => 'you cannot join this match because the nessecary third party account link on your user is missing. Check the single sign-on section of your profile.',
    'cannotcreatethirdparty' => 'you cannot create a match with this game because the nessecary third party account link on your user is missing. Check the single sign-on section of your profile.',
    'replayavailable' => 'Replay available',
    'Replays' => 'Replays',
    'ReplayName' => 'Name',
    'ReplaySize' => 'Size',
    'ReplayCreated' => 'Created',


];
