<?php

//
// Stu's Dev Kit
//
// Building blocks for assembling the things you need to build, in a way
// that will last.
//
// Copyright (c) 2026-present Stuart Herbert
// All rights reserved.
//
// Redistribution and use in source and binary forms, with or without
// modification, are permitted provided that the following conditions
// are met:
//
//   * Re-distributions of source code must retain the above copyright
//     notice, this list of conditions and the following disclaimer.
//
//   * Redistributions in binary form must reproduce the above copyright
//     notice, this list of conditions and the following disclaimer in
//     the documentation and/or other materials provided with the
//     distribution.
//
//   * Neither the names of the copyright holders nor the names of his
//     contributors may be used to endorse or promote products derived
//     from this software without specific prior written permission.
//
// THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
// "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
// LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
// FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
// COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
// INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
// BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
// LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
// CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
// LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
// ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
// POSSIBILITY OF SUCH DAMAGE.
//

declare(strict_types=1);
namespace StusDevKit\DateTimeKit\Tests\Unit;

use DateInterval;
use DateTimeImmutable;
use DateTimeInterface;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use StusDevKit\DateTimeKit\Now;
use StusDevKit\DateTimeKit\When;

#[TestDox('Now')]
class NowTest extends TestCase
{
    // ================================================================
    //
    // Setup / Teardown
    //
    // ----------------------------------------------------------------

    protected function setUp(): void
    {
        // ensure a clean state for every test
        Now::init();
    }

    // ================================================================
    //
    // Constructors
    //
    // ----------------------------------------------------------------

    // ----------------------------------------------------------------
    // init()

    #[TestDox('::init() sets Now to the current datetime')]
    public function test_init_sets_now_to_current_datetime(): void
    {
        // ----------------------------------------------------------------
        // explain your test

        // this test proves that init() sets Now to a datetime
        // close to the actual current time

        // ----------------------------------------------------------------
        // setup your test

        $before = new When('now');

        // ----------------------------------------------------------------
        // perform the change

        Now::init();

        // ----------------------------------------------------------------
        // test the results

        $after = new When('now');
        $now = Now::asWhen();

        $this->assertGreaterThanOrEqual(
            $before->asUnixTimestamp(),
            $now->asUnixTimestamp(),
        );
        $this->assertLessThanOrEqual(
            $after->asUnixTimestamp(),
            $now->asUnixTimestamp(),
        );
    }

    // ----------------------------------------------------------------
    // reset()

    #[TestDox('::reset() updates Now to the current datetime')]
    public function test_reset_updates_now_to_current_datetime(): void
    {
        // ----------------------------------------------------------------
        // explain your test

        // this test proves that reset() updates Now to the
        // current datetime, replacing whatever was set before

        // ----------------------------------------------------------------
        // setup your test

        Now::setTestClock('2020-01-01 00:00:00');

        // ----------------------------------------------------------------
        // perform the change

        Now::reset();

        // ----------------------------------------------------------------
        // test the results

        $now = Now::asWhen();

        // the year should no longer be 2020
        $this->assertNotSame(2020, $now->getYear());
    }

    // ================================================================
    //
    // Accessors
    //
    // ----------------------------------------------------------------

    // ----------------------------------------------------------------
    // now()

    #[TestDox('::now() returns a When instance')]
    public function test_now_returns_when_instance(): void
    {
        // ----------------------------------------------------------------
        // explain your test

        // this test proves that now() returns a When instance

        // ----------------------------------------------------------------
        // setup your test

        Now::setTestClock('2025-06-15 10:30:00');

        // ----------------------------------------------------------------
        // perform the change

        $result = Now::now();

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(When::class, $result);
    }

    #[TestDox('::now() returns the same value on repeated calls')]
    public function test_now_returns_same_value_on_repeated_calls(): void
    {
        // ----------------------------------------------------------------
        // explain your test

        // this test proves that repeated calls to now()
        // return the exact same When object

        // ----------------------------------------------------------------
        // setup your test

        Now::setTestClock('2025-06-15 10:30:00');

        // ----------------------------------------------------------------
        // perform the change

        $result1 = Now::now();
        $result2 = Now::now();

        // ----------------------------------------------------------------
        // test the results

        $this->assertSame($result1, $result2);
    }

    // ----------------------------------------------------------------
    // asDatabaseField()

    #[TestDox('::asDatabaseField() returns a database-compatible string')]
    public function test_asDatabaseField_returns_database_string(): void
    {
        // ----------------------------------------------------------------
        // explain your test

        // this test proves that asDatabaseField() returns
        // an ATOM-formatted datetime string suitable for
        // Postgres datetime columns

        // ----------------------------------------------------------------
        // setup your test

        Now::setTestClock('2025-06-15 10:30:00+00:00');

        // ----------------------------------------------------------------
        // perform the change

        $result = Now::asDatabaseField();

        // ----------------------------------------------------------------
        // test the results

        $this->assertSame(
            '2025-06-15T10:30:00+00:00',
            $result,
        );
    }

    #[TestDox('::asDatabaseField() returns the same value on repeated calls')]
    public function test_asDatabaseField_returns_same_value_on_repeated_calls(): void
    {
        // ----------------------------------------------------------------
        // explain your test

        // this test proves that repeated calls to asDatabaseField()
        // return the exact same value

        // ----------------------------------------------------------------
        // setup your test

        Now::setTestClock('2025-06-15 10:30:00+00:00');

        // ----------------------------------------------------------------
        // perform the change

        $result1 = Now::asDatabaseField();
        $result2 = Now::asDatabaseField();

        // ----------------------------------------------------------------
        // test the results

        $this->assertSame($result1, $result2);
    }

    // ----------------------------------------------------------------
    // asDateTimeInterface()

    #[TestDox('::asDateTimeInterface() returns a DateTimeInterface')]
    public function test_asDateTimeInterface_returns_datetime_interface(): void
    {
        // ----------------------------------------------------------------
        // explain your test

        // this test proves that asDateTimeInterface() returns a
        // DateTimeInterface instance

        // ----------------------------------------------------------------
        // setup your test

        Now::setTestClock('2025-06-15 10:30:00');

        // ----------------------------------------------------------------
        // perform the change

        $result = Now::asDateTimeInterface();

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(DateTimeInterface::class, $result);
    }

    #[TestDox('::asDateTimeInterface() returns the same value on repeated calls')]
    public function test_asDateTimeInterface_returns_same_value_on_repeated_calls(): void
    {
        // ----------------------------------------------------------------
        // explain your test

        // this test proves that repeated calls to
        // asDateTimeInterface() return the exact same object

        // ----------------------------------------------------------------
        // setup your test

        Now::setTestClock('2025-06-15 10:30:00');

        // ----------------------------------------------------------------
        // perform the change

        $result1 = Now::asDateTimeInterface();
        $result2 = Now::asDateTimeInterface();

        // ----------------------------------------------------------------
        // test the results

        $this->assertSame($result1, $result2);
    }

    // ----------------------------------------------------------------
    // asUnixTimestamp()

    #[TestDox('::asUnixTimestamp() returns a UNIX timestamp')]
    public function test_asUnixTimestamp_returns_unix_timestamp(): void
    {
        // ----------------------------------------------------------------
        // explain your test

        // this test proves that asUnixTimestamp() returns the
        // expected UNIX timestamp integer

        // ----------------------------------------------------------------
        // setup your test

        $expectedTimestamp = 1718451000;
        Now::setTestClock($expectedTimestamp);

        // ----------------------------------------------------------------
        // perform the change

        $result = Now::asUnixTimestamp();

        // ----------------------------------------------------------------
        // test the results

        $this->assertSame($expectedTimestamp, $result);
    }

    #[TestDox('::asUnixTimestamp() returns the same value on repeated calls')]
    public function test_asUnixTimestamp_returns_same_value_on_repeated_calls(): void
    {
        // ----------------------------------------------------------------
        // explain your test

        // this test proves that repeated calls to asUnixTimestamp()
        // return the exact same value

        // ----------------------------------------------------------------
        // setup your test

        Now::setTestClock(1718451000);

        // ----------------------------------------------------------------
        // perform the change

        $result1 = Now::asUnixTimestamp();
        $result2 = Now::asUnixTimestamp();

        // ----------------------------------------------------------------
        // test the results

        $this->assertSame($result1, $result2);
    }

    // ----------------------------------------------------------------
    // asWhen()

    #[TestDox('::asWhen() returns a When instance')]
    public function test_asWhen_returns_when_instance(): void
    {
        // ----------------------------------------------------------------
        // explain your test

        // this test proves that asWhen() returns a When instance

        // ----------------------------------------------------------------
        // setup your test

        Now::setTestClock('2025-06-15 10:30:00');

        // ----------------------------------------------------------------
        // perform the change

        $result = Now::asWhen();

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(When::class, $result);
    }

    #[TestDox('::asWhen() returns the same value on repeated calls')]
    public function test_asWhen_returns_same_value_on_repeated_calls(): void
    {
        // ----------------------------------------------------------------
        // explain your test

        // this test proves that repeated calls to asWhen()
        // return the exact same When object

        // ----------------------------------------------------------------
        // setup your test

        Now::setTestClock('2025-06-15 10:30:00');

        // ----------------------------------------------------------------
        // perform the change

        $result1 = Now::asWhen();
        $result2 = Now::asWhen();

        // ----------------------------------------------------------------
        // test the results

        $this->assertSame($result1, $result2);
    }

    // ----------------------------------------------------------------
    // or()

    #[TestDox('::or() returns Now when given null')]
    public function test_or_returns_now_when_given_null(): void
    {
        // ----------------------------------------------------------------
        // explain your test

        // this test proves that or() returns the current Now
        // value when given null

        // ----------------------------------------------------------------
        // setup your test

        Now::setTestClock('2025-06-15 10:30:00');
        $expectedWhen = Now::asWhen();

        // ----------------------------------------------------------------
        // perform the change

        $result = Now::or(null);

        // ----------------------------------------------------------------
        // test the results

        $this->assertSame($expectedWhen, $result);
    }

    #[TestDox('::or() returns a When from a string input')]
    public function test_or_returns_when_from_string(): void
    {
        // ----------------------------------------------------------------
        // explain your test

        // this test proves that or() creates a When from a
        // string input rather than returning Now

        // ----------------------------------------------------------------
        // setup your test

        Now::setTestClock('2025-06-15 10:30:00');

        // ----------------------------------------------------------------
        // perform the change

        $result = Now::or('2024-01-01 00:00:00');

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(When::class, $result);
        $this->assertSame(2024, $result->getYear());
        $this->assertSame(1, $result->getMonthOfYear());
        $this->assertSame(1, $result->getDayOfMonth());
    }

    #[TestDox('::or() returns a When from a UNIX timestamp input')]
    public function test_or_returns_when_from_int(): void
    {
        // ----------------------------------------------------------------
        // explain your test

        // this test proves that or() creates a When from a
        // UNIX timestamp input rather than returning Now

        // ----------------------------------------------------------------
        // setup your test

        Now::setTestClock('2025-06-15 10:30:00');
        $timestamp = 1718451000;

        // ----------------------------------------------------------------
        // perform the change

        $result = Now::or($timestamp);

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(When::class, $result);
        $this->assertSame($timestamp, $result->asUnixTimestamp());
    }

    #[TestDox('::or() returns a When from a DateTimeInterface input')]
    public function test_or_returns_when_from_datetime_interface(): void
    {
        // ----------------------------------------------------------------
        // explain your test

        // this test proves that or() creates a When from a
        // DateTimeInterface input rather than returning Now

        // ----------------------------------------------------------------
        // setup your test

        Now::setTestClock('2025-06-15 10:30:00');
        $input = new DateTimeImmutable('2024-03-20 14:00:00+00:00');

        // ----------------------------------------------------------------
        // perform the change

        $result = Now::or($input);

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(When::class, $result);
        $this->assertSame(2024, $result->getYear());
        $this->assertSame(3, $result->getMonthOfYear());
        $this->assertSame(20, $result->getDayOfMonth());
    }

    #[TestDox('::or() returns the same value on repeated calls with null')]
    public function test_or_returns_same_value_on_repeated_null_calls(): void
    {
        // ----------------------------------------------------------------
        // explain your test

        // this test proves that repeated calls to or() with null
        // return the exact same When object

        // ----------------------------------------------------------------
        // setup your test

        Now::setTestClock('2025-06-15 10:30:00');

        // ----------------------------------------------------------------
        // perform the change

        $result1 = Now::or(null);
        $result2 = Now::or(null);

        // ----------------------------------------------------------------
        // test the results

        $this->assertSame($result1, $result2);
    }

    // ================================================================
    //
    // Test clock support
    //
    // ----------------------------------------------------------------

    // ----------------------------------------------------------------
    // setTestClock()

    #[TestDox('::setTestClock() sets Now from a string')]
    public function test_setTestClock_sets_now_from_string(): void
    {
        // ----------------------------------------------------------------
        // explain your test

        // this test proves that setTestClock() sets the value
        // of Now from a date/time string

        // ----------------------------------------------------------------
        // setup your test



        // ----------------------------------------------------------------
        // perform the change

        Now::setTestClock('2024-03-20 14:30:00+00:00');

        // ----------------------------------------------------------------
        // test the results

        $when = Now::asWhen();
        $this->assertSame(2024, $when->getYear());
        $this->assertSame(3, $when->getMonthOfYear());
        $this->assertSame(20, $when->getDayOfMonth());
        $this->assertSame(14, $when->getHour());
        $this->assertSame(30, $when->getMinutes());
        $this->assertSame(0, $when->getSeconds());
    }

    #[TestDox('::setTestClock() sets Now from a UNIX timestamp')]
    public function test_setTestClock_sets_now_from_int(): void
    {
        // ----------------------------------------------------------------
        // explain your test

        // this test proves that setTestClock() sets the value
        // of Now from a UNIX timestamp

        // ----------------------------------------------------------------
        // setup your test

        $timestamp = 1718451000;

        // ----------------------------------------------------------------
        // perform the change

        Now::setTestClock($timestamp);

        // ----------------------------------------------------------------
        // test the results

        $this->assertSame($timestamp, Now::asUnixTimestamp());
    }

    #[TestDox('::setTestClock() sets Now from a DateTimeInterface')]
    public function test_setTestClock_sets_now_from_datetime_interface(): void
    {
        // ----------------------------------------------------------------
        // explain your test

        // this test proves that setTestClock() sets the value
        // of Now from a DateTimeInterface object

        // ----------------------------------------------------------------
        // setup your test

        $input = new DateTimeImmutable('2024-03-20 14:30:00+00:00');

        // ----------------------------------------------------------------
        // perform the change

        Now::setTestClock($input);

        // ----------------------------------------------------------------
        // test the results

        $when = Now::asWhen();
        $this->assertSame(2024, $when->getYear());
        $this->assertSame(3, $when->getMonthOfYear());
        $this->assertSame(20, $when->getDayOfMonth());
    }

    #[TestDox('::setTestClock() sets Now from a When instance')]
    public function test_setTestClock_sets_now_from_when(): void
    {
        // ----------------------------------------------------------------
        // explain your test

        // this test proves that setTestClock() sets the value
        // of Now from a When instance

        // ----------------------------------------------------------------
        // setup your test

        $input = new When('2024-03-20 14:30:00+00:00');

        // ----------------------------------------------------------------
        // perform the change

        Now::setTestClock($input);

        // ----------------------------------------------------------------
        // test the results

        $when = Now::asWhen();
        $this->assertSame(2024, $when->getYear());
        $this->assertSame(3, $when->getMonthOfYear());
        $this->assertSame(20, $when->getDayOfMonth());
    }

    // ----------------------------------------------------------------
    // modifyTestClock()

    #[TestDox('::modifyTestClock() modifies Now using a relative modifier')]
    public function test_modifyTestClock_modifies_now(): void
    {
        // ----------------------------------------------------------------
        // explain your test

        // this test proves that modifyTestClock() applies a PHP
        // relative datetime modifier to the current value of Now

        // ----------------------------------------------------------------
        // setup your test

        Now::setTestClock('2025-06-15 10:30:00+00:00');

        // ----------------------------------------------------------------
        // perform the change

        Now::modifyTestClock('+1 day');

        // ----------------------------------------------------------------
        // test the results

        $when = Now::asWhen();
        $this->assertSame(2025, $when->getYear());
        $this->assertSame(6, $when->getMonthOfYear());
        $this->assertSame(16, $when->getDayOfMonth());
        $this->assertSame(10, $when->getHour());
        $this->assertSame(30, $when->getMinutes());
    }

    #[TestDox('::modifyTestClock() can subtract time')]
    public function test_modifyTestClock_can_subtract_time(): void
    {
        // ----------------------------------------------------------------
        // explain your test

        // this test proves that modifyTestClock() can use a
        // negative modifier to move time backwards

        // ----------------------------------------------------------------
        // setup your test

        Now::setTestClock('2025-06-15 10:30:00+00:00');

        // ----------------------------------------------------------------
        // perform the change

        Now::modifyTestClock('-3 hours');

        // ----------------------------------------------------------------
        // test the results

        $when = Now::asWhen();
        $this->assertSame(2025, $when->getYear());
        $this->assertSame(6, $when->getMonthOfYear());
        $this->assertSame(15, $when->getDayOfMonth());
        $this->assertSame(7, $when->getHour());
        $this->assertSame(30, $when->getMinutes());
    }

    // ----------------------------------------------------------------
    // addToTestClock()

    #[TestDox('::addToTestClock() adds a DateInterval to Now')]
    public function test_addToTestClock_adds_dateinterval(): void
    {
        // ----------------------------------------------------------------
        // explain your test

        // this test proves that addToTestClock() adds a
        // DateInterval object to the current value of Now

        // ----------------------------------------------------------------
        // setup your test

        Now::setTestClock('2025-06-15 10:30:00+00:00');
        $interval = new DateInterval('P1D');

        // ----------------------------------------------------------------
        // perform the change

        Now::addToTestClock($interval);

        // ----------------------------------------------------------------
        // test the results

        $when = Now::asWhen();
        $this->assertSame(2025, $when->getYear());
        $this->assertSame(6, $when->getMonthOfYear());
        $this->assertSame(16, $when->getDayOfMonth());
        $this->assertSame(10, $when->getHour());
        $this->assertSame(30, $when->getMinutes());
    }

    #[TestDox('::addToTestClock() adds an interval string to Now')]
    public function test_addToTestClock_adds_interval_string(): void
    {
        // ----------------------------------------------------------------
        // explain your test

        // this test proves that addToTestClock() accepts a string
        // in DateInterval format and adds it to Now

        // ----------------------------------------------------------------
        // setup your test

        Now::setTestClock('2025-06-15 10:30:00+00:00');

        // ----------------------------------------------------------------
        // perform the change

        Now::addToTestClock('PT2H30M');

        // ----------------------------------------------------------------
        // test the results

        $when = Now::asWhen();
        $this->assertSame(2025, $when->getYear());
        $this->assertSame(6, $when->getMonthOfYear());
        $this->assertSame(15, $when->getDayOfMonth());
        $this->assertSame(13, $when->getHour());
        $this->assertSame(0, $when->getMinutes());
    }

    // ----------------------------------------------------------------
    // subFromTestClock()

    #[TestDox('::subFromTestClock() subtracts a DateInterval from Now')]
    public function test_subFromTestClock_subtracts_dateinterval(): void
    {
        // ----------------------------------------------------------------
        // explain your test

        // this test proves that subFromTestClock() subtracts a
        // DateInterval object from the current value of Now

        // ----------------------------------------------------------------
        // setup your test

        Now::setTestClock('2025-06-15 10:30:00+00:00');
        $interval = new DateInterval('P1D');

        // ----------------------------------------------------------------
        // perform the change

        Now::subFromTestClock($interval);

        // ----------------------------------------------------------------
        // test the results

        $when = Now::asWhen();
        $this->assertSame(2025, $when->getYear());
        $this->assertSame(6, $when->getMonthOfYear());
        $this->assertSame(14, $when->getDayOfMonth());
        $this->assertSame(10, $when->getHour());
        $this->assertSame(30, $when->getMinutes());
    }

    #[TestDox('::subFromTestClock() subtracts an interval string from Now')]
    public function test_subFromTestClock_subtracts_interval_string(): void
    {
        // ----------------------------------------------------------------
        // explain your test

        // this test proves that subFromTestClock() accepts a string
        // in DateInterval format and subtracts it from Now

        // ----------------------------------------------------------------
        // setup your test

        Now::setTestClock('2025-06-15 10:30:00+00:00');

        // ----------------------------------------------------------------
        // perform the change

        Now::subFromTestClock('PT2H30M');

        // ----------------------------------------------------------------
        // test the results

        $when = Now::asWhen();
        $this->assertSame(2025, $when->getYear());
        $this->assertSame(6, $when->getMonthOfYear());
        $this->assertSame(15, $when->getDayOfMonth());
        $this->assertSame(8, $when->getHour());
        $this->assertSame(0, $when->getMinutes());
    }
}
