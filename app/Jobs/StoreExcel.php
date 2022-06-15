<?php

namespace App\Jobs;

use App\Exports\UsersExport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;

class StoreExcel implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $dateStart;
    private $dateEnd;
    private $fileName;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $dateStart, string $dateEnd, string $fileName)
    {
        $this->dateStart = $dateStart;
        $this->dateEnd = $dateEnd;
        $this->fileName = $fileName;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Excel::store(new UsersExport($this->dateStart, $this->dateEnd), "/Excel/" .$this->fileName);
    }
}
