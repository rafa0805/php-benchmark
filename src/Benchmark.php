<?php
namespace Rafa0805\PhpBenchmark;

class Benchmark
{

  /**
   * @param callable $subject
   * @param int $times
   * @return void
   * @throws \InvalidArgumentException
   */
  public static function doRepeat(callable $subject, int $times = 1): void
  {
    if ($times < 1) {
      throw new \InvalidArgumentException('Iterations must be a positive integer');
    }

    $summary = self::repeatSummary(self::repeat($subject, $times));

    self::echoRepeatResult($summary);
  }

  /**
   * @param callable $subject
   * @param int $times
   * @return array
   */
  private static function repeat(callable $subject, int $times = 1): array
  {
    return array_map(fn() => self::laps($subject), range(1, $times));
  }

  /**
   * @param callable $f
   * @return float
   */
  private static function laps(callable $f): float
  {
    $t_start = microtime(true);
    $f();
    $t_end = microtime(true);
    return $t_end - $t_start;
  }

  /**
   * @param float[] $result
   * @return array{min: float, max: float, avg: float, total: float, times: int}
   */
  private static function repeatSummary(array $results):array
  {
    return [
      'min' => min($results),
      'max' => max($results),
      'avg' => array_sum($results) / count($results),
      'total' => array_sum($results),
      'times' => count($results)
    ];
  }

  /**
   * @param array{min: float, max: float, avg: float, total: float, times: int} $summary
   * @return void
   */
  private static function echoRepeatResult(array $summary): void
  {
    echo "Min: {$summary['min']}\n";
    echo "Max: {$summary['max']}\n";
    echo "Avg: {$summary['avg']}\n";
    echo "Total: {$summary['total']}\n";
    echo "Times: {$summary['times']}\n";
  }



}
