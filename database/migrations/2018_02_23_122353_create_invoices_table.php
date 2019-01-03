<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('password')->nullable();
            $table->string('number')->nullable();
            $table->integer('user_id');
            $table->enum('type', ['sale', 'purchase']);


            $table->decimal('total', 15, 0);
            $table->decimal('tax', 15, 0)->nullable();
            $table->decimal('discount', 15, 0)->nullable();


            //Status
            //draft: نیاز به ویرایش دارد و پیش نویس است
            //submitted: فاکتوری است که خودمان ثبت کردیم و نیاز است مراحل پرداخت آن را تعریف کنیم و پس از ثبت ایمیل برای کاربر ارسال می شود که در صورت نیاز آن را آنلاین پرداخت کند.
            //approved:پردازش تایید شده است یعنی می توانیم کالا ها را ارسال کنیم و تایید ارسال فاکتور برای کاربر اطلاع می دهیم
            //paid:فاکتوری است که توسط کاربر پرداخت می شود و نیاز به پردازش دارد تا به حالت approved برود
            //payment: فاکتوری است که در حالت پرداخت است اقساطی، اعتباری و....
            //post:فاکتوری است که به پست تحویل شده است
            //done: فاکتوری است که کالا به دست مشتری رسیده است و کلیه فرآیند های آن از ارسال تا پرداخت انجام شده است.

            $table->enum('status', ['draft', 'sent', 'submitted', 'approved', 'paid', 'done', 'post', 'payment'])->default('submitted');


            //Information
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('zip_code')->nullable();
            $table->text('address')->nullable();
            $table->text('location')->nullable();
            $table->integer('province_id')->nullable();
            $table->integer('city_id')->nullable();

            //Options
            $table->string('attachment')->nullable();
            $table->text('note')->nullable();
            $table->longText('options')->nullable();

            //Times
            $table->timestamp('invoice_at')->nullable();
            $table->timestamp('due_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('records', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->decimal('price', 15, 0);
            $table->decimal('quantity', 15, 0)->default(1);
            $table->decimal('total', 15, 0);
            $table->integer('invoice_id');
            $table->integer('product_id')->nullable();
            $table->longText('options')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
        Schema::dropIfExists('records');
    }
}