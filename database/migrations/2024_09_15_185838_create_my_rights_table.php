<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('my_rights', function (Blueprint $table) {
            $table->id();
            $table->text('title')->nullable();
            $table->longText('text_definition')->nullable();
            $table->longText('simplefied')->nullable();
            $table->timestamps();
        });

        DB::table('my_rights')->insert([
            [
                'title' => 'Freedom of Expression',
                'text_definition' => 'Congress shall make no law respecting an establishment of religion, or prohibiting the free exercise thereof; or abridging the freedom of speech, or of the press; or the right of the people peaceably to assemble, and to petition the Government for a redress of grievances.', // Set a unique email
                'simplefied' => 'The First Amendment protects fundamental freedoms of individuals: freedom of religion, speech, press, assembly, and the right to petition the government. It ensures individuals can express themselves, practice their beliefs, and engage in political activities without government interference.',
                'created_at' => '2024-01-10 13:32:33',
                'updated_at' => now(),
            ],
            [
                'title' => 'Right to Bear Arms',
                'text_definition' => 'A well regulated Militia, being necessary to the security of a free State, the right of the people to keep and bear Arms, shall not be infringed.',
                'simplefied' => 'Ensures the right of individuals to own and carry firearms.',
                'created_at' => '2024-01-10 13:32:33',
                'updated_at' => now(),
            ],
            [
                'title' => 'No Quartering Soldiers',
                'text_definition' => 'No Soldier shall, in time of peace be quartered in any house, without the consent of the Owner, nor in time of war, but in a manner to be prescribed by law.',
                'simplefied' => 'Prohibits the government from forcibly housing soldiers in private homes during times of peace without the consent of the homeowner, protecting citizens privacy and property rights.',
                'created_at' => '2024-01-10 13:32:33',
                'updated_at' => now(),
            ],
            [
                'title' => 'No Unreasonable Searches and Seizures',
                'text_definition' => 'The right of the people to be secure in their persons, houses, papers, and effects, against unreasonable searches and seizures, shall not be violated, and no Warrants shall issue, but upon probable cause, supported by Oath or affirmation, and particularly describing the place to be searched, and the persons or things to be seized.',
                'simplefied' => "Protects against unreasonable searches and seizures, requiring warrants based on probable cause for searches and arrests, safeguarding individuals' privacy and property rights.",
                'created_at' => '2024-01-10 13:32:33',
                'updated_at' => now(),
            ],
            [
                'title' => 'Rights of the Accused',
                'text_definition' => 'No person shall be held to answer for a capital, or otherwise infamous crime, unless on a presentment or indictment of a Grand Jury, except in cases arising in the land or naval forces, or in the Militia, when in actual service in time of War or public danger; nor shall any person be subject for the same offence to be twice put in jeopardy of life or limb; nor shall be compelled in any criminal case to be a witness against himself, nor be deprived of life, liberty, or property, without due process of law; nor shall private property be taken for public use, without just compensation.',
                'simplefied' => 'Safeguards various rights of the accused, including protection against self-incrimination, double jeopardy, and deprivation of life, liberty, or property without due process of law.',
                'created_at' => '2024-01-10 13:32:33',
                'updated_at' => now(),
            ],
            [
                'title' => 'Right to a Fair Trial',
                'text_definition' => 'In all criminal prosecutions, the accused shall enjoy the right to a speedy and public trial, by an impartial jury of the State and district wherein the crime shall have been committed, which district shall have been previously ascertained by law, and to be informed of the nature and cause of the accusation; to be confronted with the witnesses against him; to have compulsory process for obtaining witnesses in his favor, and to have the Assistance of Counsel for his defence.',
                'simplefied' => 'Guarantees the right to a speedy and public trial, with an impartial jury and the right to confront witnesses.',
                'created_at' => '2024-01-10 13:32:33',
                'updated_at' => now(),
            ],
            [
                'title' => 'Right to a Jury',
                'text_definition' => 'In Suits at common law, where the value in controversy shall exceed twenty dollars, the right of trial by jury shall be preserved, and no fact tried by a jury, shall be otherwise re-examined in any Court of the United States, than according to the rules of the common law.',
                'simplefied' => 'Ensures the right to a jury trial in civil cases involving disputes over property or money.',
                'created_at' => '2024-01-10 13:32:33',
                'updated_at' => now(),
            ],
            [
                'title' => 'Protection from Cruel Punishment',
                'text_definition' => 'Excessive bail shall not be required, nor excessive fines imposed, nor cruel and unusual punishments inflicted.',
                'simplefied' => 'Prohibits cruel and unusual punishment, ensuring that punishments fit the crime and do not involve excessive fines or bail.',
                'created_at' => '2024-01-10 13:32:33',
                'updated_at' => now(),
            ],
            [
                'title' => 'Rights Not Listed are Retained',
                'text_definition' => 'The enumeration in the Constitution, of certain rights, shall not be construed to deny or disparage others retained by the people.',
                'simplefied' => 'The listing of certain rights in the Constitution does not mean that others do not exist.',
                'created_at' => '2024-01-10 13:32:33',
                'updated_at' => now(),
            ],
            [
                'title' => 'Rights Reserved to the People and the States',
                'text_definition' => 'The powers not delegated to the United States by the Constitution, nor prohibited by it to the States, are reserved to the States respectively, or to the people.',
                'simplefied' => 'Powers not held by the federal government are reserved by the states or the people.',
                'created_at' => '2024-01-10 13:32:33',
                'updated_at' => now(),
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('my_rights');
    }
};
