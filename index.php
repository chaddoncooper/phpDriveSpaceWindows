<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        .windows-light-grey,.w3-hover-light-grey:hover,.w3-light-gray,.w3-hover-light-gray:hover{color:#000!important;background-color:#E6E6E6!important}
        .windows-red,.w3-hover-red:hover{color:#fff!important;background-color:#DA2626!important}
        .windows-blue,.w3-hover-blue:hover{color:#fff!important;background-color:#26A0DA!important}
        .windows-border{border: 1px solid #BCBCBC;}
        .windows-progress-bar{height:1.5em;}
        body {
            font-family: Segoe UI;
        }
    </style>
    <title>Disk Space</title>
</head>
<body>
<?php
	include 'HardDrive.php';
	
	$totalSize = 0;
	$totalUsed = 0;
	$totalFree = 0;
	
	foreach (HardDrive::GetAll() as $drive) {
		$totalSize += $drive->TotalSize();
		$totalUsed += $drive->UsedSpace();
		$totalFree += $drive->FreeSpace();
		
		DriveSpaceUsedDiv($drive->Name(), $drive->Letter(), $drive->PercentageUsed(), $drive->FileSystem(), $drive->FreeSpace(), $drive->TotalSize());
	}

	DriveSpaceUsedDiv('All Drives Total', '', Math::GetPercentage($totalSize, $totalUsed, 0), 'NTFS', $totalFree, $totalSize);
	
	function DriveSpaceUsedDiv($driveName, $driveLetter, $percentageUsed, $fileSystem, $freeSpace, $totalSize)
	{
		echo '<div style="display: flex;">
		<div style="float: left; width: 80%;">'
		, $driveName, ' ' ,FormattedDriveLetter($driveLetter),
			'<div class="windows-light-grey windows-border">
				<div class="windows-progress-bar ', PercentageClass($percentageUsed), '" style="width:', $percentageUsed, '%"></div>
			</div>
		</div>
		<div style="float: left; width: 20%; padding: 0.5em;">
			', $fileSystem, '<br>
			', FormattedDriveSpaceText($freeSpace, $totalSize), '
		</div>
	</div>
	';
	}
	
	function FormattedDriveLetter($driveLetter = '')
	{
		return $driveLetter == '' ? '' : '(' . $driveLetter . ':)';
	}
	
	function FormattedDriveSpaceText($freeSpace, $totalSize)
    {
        return HardDrive::FileSize($freeSpace) . " free of " . HardDrive::FileSize($totalSize);
    }

	function PercentageClass($percentageUsed)
	{
		if ($percentageUsed < 90) {
			return 'windows-blue';
		}
		return 'windows-red';
	}
?>
</body>
</html>
