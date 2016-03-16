<?php

/**
 * A repository to store and manipulate people information
 *
 * Class PeopleManager
 */
class PeopleManager
{
    /**
     * Storage for processed people records
     *
     * @var array
     */
    protected $items = [];

    /**
     *
     * @var array
     */
    protected $people_alive_by_year = [];

    /**
     * PeopleManager constructor
     *
     * @param $path
     */
    public function __construct($path)
    {
        $this->process($path);
    }

    /**
     * Process the input file rows into items array
     *
     * @param $path
     */
    protected function process($path)
    {
        // Detect line endings for Mac
        ini_set('auto_detect_line_endings',TRUE);

        if (($file = file($path)) !== FALSE)
        {
            $keys = null;
            foreach($file as $line)
            {
                if ($keys === null)
                {
                    $keys = str_getcsv($line);
                    continue;
                }
                $this->items[] = array_combine($keys, str_getcsv($line));
            }
        }
    }

    /**
     * Returns an array of years with the number of people alive during each year
     *
     * @return null|int
     */
    public function getPeopleAliveByYear()
    {
        if (empty($this->people_alive_by_year))
        {
            foreach ($this->items as $item)
            {
                $start = $item['start'];
                $end = $item['end'];
                foreach (range($start, $end) as $year)
                {
                    if (!isset($this->people_alive_by_year[$year]))
                    {
                        $this->people_alive_by_year[$year] = 0;
                    }

                    $this->people_alive_by_year[$year]++;
                }
            }
        }

        return $this->people_alive_by_year;
    }

    /**
     * Returns an array with the count of people alive as the key and
     * an array of years which have that count as the value
     *
     * @return array
     */
    public function getPeopleAliveYearsByCount()
    {
        $people_alive_by_count = [];

        foreach ($this->getPeopleAliveByYear() as $year => $count)
        {
            $people_alive_by_count[$count][] = $year;
        }

        return $people_alive_by_count;
    }
}
