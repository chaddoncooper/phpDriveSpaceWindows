<?php
include 'math.php';

class HardDrive
{
    protected $drive;

    public function __construct($drive)
    {
        $this->drive = $drive;
    }

    public function Letter()
    {
        return $this->drive->DriveLetter;
    }

    public function Name()
    {
        if ($this->drive->VolumeName === '') {
            return 'Local Disk';
        }
        return $this->drive->VolumeName;
    }

    public function PercentageUsed()
    {
        return Math::GetPercentage($this->drive->TotalSize, $this->UsedSpace(), 0);
    }

    public function FreeSpace()
    {
        return $this->drive->FreeSpace;
    }

    public function TotalSize()
    {
        return $this->drive->TotalSize;
    }

    public function UsedSpace()
    {
        return $this->drive->TotalSize - $this->drive->FreeSpace;
    }

    public function FileSystem()
    {
        return $this->drive->FileSystem;
    }
	
	public static function FileSize($size)
    {
        $filesizename = array(" Bytes", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");
        return $size ? round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . $filesizename[$i] : '0 Bytes';
    }

    public static function GetAll()
    {
        $fso = new COM('Scripting.FileSystemObject');
        $D = $fso->Drives;
        $type = array("Unknown", "Removable", "Fixed", "Network", "CD-ROM", "RAM Disk");
        $hardDrives = array();

        foreach ($D as $d) {
            $dO = $fso->GetDrive($d);
            if ($dO->DriveType == 3) {
                $n = $dO->Sharename;
            } else if ($dO->IsReady) {
                array_push($hardDrives, new HardDrive($dO));
            } else {
                $n = "[Drive not ready]";
            }
        }
        return $hardDrives;
    }
}
