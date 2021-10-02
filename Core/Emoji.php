<?php

namespace UnicodeEmoji\Core;

include "Constants.php";
include "Utils.php";

/**
 * Unicode emoji parser class
 *
 * @author Hakkı Konu <hakkikonu@gmail.com>
 */
class Emoji
{
    //hold txt file data here
    private $pureTxtFileData = null;

    //primary data arrays
    private $groups = [];
    private $subGroups = [];
    private $emojiMetaData = [];

    //array index
    private $groupArrayKeyCounter = 0;
    private $subGroupArrayKeyCounter = 0;
    private $emojiMetaDataKeyCounter = 0;

    function __construct()
    {
        //fetch text file from unicode.org
        $this->pureTxtFileData = $this->fetch();
        //start parser
        $this->parse();
    }

    //TODO: Handle possible remote source related network exceptions (wrong url, not found etc.)
    /**
     * Fetch txt file from source
     *
     * @return string|bool
     * @author Hakkı Konu <hakkikonu@gmail.com>
     */
    private function fetch(): string|bool
    {
        return file_get_contents(Constants::$EMOJI_SEQUENCES_URL);
    }

    /**
     * Process main emoji group name
     *
     * @param string $line 
     * @return void
     * @author Hakkı Konu <hakkikonu@gmail.com>
     */
    private function groupNameProcessor(string $line): void
    {
        if (strpos($line, "# group: ") !== false) {
            $groupName = explode("# group: ", trim($line))[1];
            $this->groups[$this->groupArrayKeyCounter]["name"] = $groupName;
            $this->groups[$this->groupArrayKeyCounter]["slug"] = Utils::slugify($groupName);
            $this->groupArrayKeyCounter++;
        }
    }

    /**
     * Process sub emoji group name
     *
     * @param string $line 
     * @return void
     * @author Hakkı Konu <hakkikonu@gmail.com>
     */
    private function subGroupNameProcessor(string $line): void
    {
        if (strpos($line, "# subgroup: ") !== false) {
            $subGroupName =  explode("# subgroup: ", trim($line))[1];
            $this->subGroups[$this->subGroupArrayKeyCounter]["name"] = $subGroupName;
            $this->subGroups[$this->subGroupArrayKeyCounter]["slug"] = Utils::slugify($subGroupName);
            $this->subGroupArrayKeyCounter++;
        }
    }

    /**
     * Process emoji related meta data
     *
     * @param string $line 
     * @return void
     * @author Hakkı Konu <hakkikonu@gmail.com>
     */
    private function emojiMetaDataProcessor(string $line): void
    {
        if (strpos($line, "-qualified") !== false && strpos($line, ";") !== false && strpos($line, "#")) {
            $this->emojiMetaData[$this->emojiMetaDataKeyCounter]["id"] = $this->emojiMetaDataKeyCounter;
            $leftRight = explode(";", $line);
            //unicode strings
            $codesPartString = trim($leftRight[0]);
            $codesArr = explode(" ", $codesPartString);
            $this->emojiMetaData[$this->emojiMetaDataKeyCounter]["codes"] = $codesArr;

            //emoji side
            $emojiSide = $leftRight[1]; //# 😀 E1.0 grinning face
            $afterSharpSignString = explode("# ", $emojiSide)[1]; // 😀 E1.0 grinning face
            $afterSharpSignArr = explode(" ", $afterSharpSignString, 3);
            //Emoji symbol
            $emojiSymbol = $afterSharpSignArr[0]; //😀
            $this->emojiMetaData[$this->emojiMetaDataKeyCounter]["symbol"] = $emojiSymbol;
            //TODO: What is this?
            /**  @see source? */
            $e = $afterSharpSignArr[1]; // E1.0
            $this->emojiMetaData[$this->emojiMetaDataKeyCounter]["e"] = $e;
            //Emoji name
            $emojiName = $afterSharpSignArr[2]; //grinning face
            $this->emojiMetaData[$this->emojiMetaDataKeyCounter]["name"] = $emojiName;
            $this->emojiMetaData[$this->emojiMetaDataKeyCounter]["variableName"] = Utils::camelCase($emojiName);
            $this->emojiMetaData[$this->emojiMetaDataKeyCounter]["mainGroup"] = $this->groups[$this->groupArrayKeyCounter - 1];
            $this->emojiMetaData[$this->emojiMetaDataKeyCounter]["subGroup"] = $this->subGroups[$this->subGroupArrayKeyCounter - 1];
            $this->emojiMetaDataKeyCounter++;
        }
    }

    /**
     * Call sub parsers here
     *
     * @return bool
     * @author Hakkı Konu <hakkikonu@gmail.com>
     */
    private function parse(): bool
    {
        if ($this->pureTxtFileData == null) {
            return false;
        }

        $textFileLinesArr = explode("\n", (string)$this->pureTxtFileData);

        foreach ($textFileLinesArr as $line) {
            //This is the main group's line
            $this->groupNameProcessor($line);
            //This is the subgroup name's line
            $this->subGroupNameProcessor($line);
            //emoji metadata line
            $this->emojiMetaDataProcessor($line);
        }

        return true;
    }

    // * * * * * Getters * * * * *

    /**
     * Sub emoji group names
     *
     * @param bool $json Convert json or not
     * @return mixed
     * @author Hakkı Konu <hakkikonu@gmail.com>
     */
    public function getSubGroups(bool $json = false): mixed
    {
        return  $json ? json_encode($this->subGroups) : $this->subGroups;
    }

    /**
     * Main emoji group names
     *
     * @param bool $json Convert json or not
     * @return mixed
     * @author Hakkı Konu <hakkikonu@gmail.com>
     */
    public function getMainGroups(bool $json = false): mixed
    {
        return $json ? json_encode($this->groups) : $this->groups;
    }

    /**
     * Full emoji list
     *
     * @param bool $json Convert json or not
     * @return mixed
     * @author Hakkı Konu <hakkikonu@gmail.com>
     */
    public function getEmojis(bool $json = false): mixed
    {
        return  $json ?  json_encode($this->emojiMetaData) : $this->emojiMetaData;
    }
}
