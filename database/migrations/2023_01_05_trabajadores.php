<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('trabajadores', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->unsignedBigInteger("idRol");
            $table->foreign("idRol")->on("roles")->references("id")->onDelete("cascade")->onUpdate("cascade");
            $table->string("apellidos");
            $table->string("telefono");
            $table->string("dni");
            $table->string("codigoQr");//res_qr_(idPersona)_(codigoContrato)
            $table->binary("imagenQr");//blob

            // $table->unsignedBigInteger("idNomina");
            // $table->foreign("idNomina")->on("nominas")->references("id")->onDelete("cascade")->onUpdate("cascade");

            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trabajadores');
    }
};