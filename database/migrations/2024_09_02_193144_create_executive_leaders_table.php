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
        Schema::create('executive_leaders', function (Blueprint $table) {
            $table->id();
            $table->string('state', 255)->nullable();
            $table->string('user_name', 255)->nullable();
            $table->string('first_name', 255)->nullable();
            $table->string('last_name', 255)->nullable();
            $table->string('party', 50)->nullable();
            $table->string('jurisdiction', 255)->nullable();
            $table->string('city', 255)->nullable();
            $table->string('committees')->nullable();
            $table->date('birthday')->nullable();
            $table->string('religion', 255)->nullable();
            $table->boolean('on_the_ballot')->default(false);
            $table->string('birth_place', 150)->nullable();
            $table->string('home_city', 255)->nullable();
            $table->longText('education')->nullable();
            $table->longText('contact_campaign_other')->nullable();
            $table->string('campaign_website', 255)->nullable();
            $table->string('dc_contact', 255)->nullable();
            $table->string('dc_website', 255)->nullable();
            $table->string('instagram', 255)->nullable();
            $table->string('facebook', 255)->nullable();
            $table->string('twitter', 255)->nullable();
            $table->string('linkedin', 255)->nullable();
            $table->string('youtube', 255)->nullable();
            $table->longText('political_experience')->nullable();
            $table->longText('professional_experience')->nullable();
            $table->longText('military_experience')->nullable();
            $table->longText('other_experience')->nullable();
            $table->longText('other_facts')->nullable();
            $table->timestamps();
        });

        DB::table('executive_leaders')->insert([
            [
                'state' => 'United States of America',
                'user_name' => 'joe-biden',
                'first_name' => 'Joseph "Joe"',
                'last_name' => 'Biden, Jr.',
                'party' => 'Democratic',
                'jurisdiction' => 'United States of America',
                'city' => 'Wilmington, DE',
                'committees' => null,
                'birthday' => '1942-11-20',
                'religion' => 'Roman Catholic',
                'on_the_ballot' => true,
                'birth_place' => 'Scranton, PA',
                'home_city' => 'Wilmington, DE',
                'education' => "JD, Syracuse University College of Law, 1968\nBA, History/Political Science, University of Delaware, 1965",
                'contact_campaign_other' => "https://www.instagram.com/joebiden\nhttps://www.facebook.com/joebiden\nhttps://twitter.com/joebiden\nhttps://www.youtube.com/joebiden",
                'campaign_website' => 'https://joebiden.com/',
                'dc_contact' => 'https://www.whitehouse.gov/contact/',
                'dc_website' => 'https://www.whitehouse.gov/',
                'instagram' => 'https://www.instagram.com/whitehouse/',
                'facebook' => "https://www.facebook.com/WhiteHouse/\nhttps://www.facebook.com/POTUS",
                'twitter' => 'https://twitter.com/potus?lang=en',
                'linkedin' => null,
                'youtube' => 'https://www.youtube.com/user/whitehouse',
                'political_experience' => "46th President, United States of America, 2021-present\nCandidate, President of the United States, 1988, 2008, 2020, 2024\nPresident, United States Senate, 2009-2017\nVice President, United States of America, 2009-2017\nSenator, United States Senate, 1972-2008\nMember, New Castle County Council, 1970-1972",
                'professional_experience' => "Former Adjunct Professor, Widener University School of Law\nFormer Attorney/Public Defender, 1969-1972",
                'military_experience' => null,
                'other_experience' => "Co-Founder/Former Board Co-Chair, The Biden Cancer Initiative\nCo-Founder, The Biden Foundation\nFounder, The Biden Institute at the University of Delaware\nFounder, The Penn Biden Center for Diplomacy and Global Engagement",
                'other_facts' => "Current Car: 1967 Corvette\nFavorite Book: American Gospel, Irish America\nFavorite Food: Pasta\nFavorite Quote: \"History says, don't hope on this side of the grave. But then, once in a lifetime the longed for tidal wave of justice can rise up, and hope and history rhyme. So hope for a great sea-change on the far side of revenge. Believe that a further shore is reachable from here. Believe in miracles and cures and healing wells.\" - Seamus Heaney's \"The Cure at Troy\"\nFirst Car: Chevrolet Convertible\nFirst Job: Lifeguard\nHobbies or Special Talents: Weightlifting, designing homes, sketching\nPets (include names): 1 dog (Major)\nPublications: \"Promises to Keep: On Life and Politics\" - 2007, \"Promise Me Dad: A Year of Hope\" - 2017",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'state' => 'United States of America',
                'user_name' => '',
                'first_name' => 'Kamala',
                'last_name' => 'Harris',
                'party' => 'Democratic',
                'jurisdiction' => 'United States of America',
                'city' => 'San Francisco, CA',
                'committees' => null, // No committee information provided
                'birthday' => '1964-10-20',
                'religion' => 'Baptist',
                'on_the_ballot' => true,
                'birth_place' => 'Oakland, CA',
                'home_city' => 'San Francisco, CA',
                'education' => "JD, University of California, Hastings College of the Law, 1990\nBA, Political Science/Economics, Howard University, 1986",
                'contact_campaign_other' => 'https://twitter.com/KamalaHarris',
                'campaign_website' => 'https://www.whitehouse.gov/contact/',
                'dc_contact' => 'https://www.whitehouse.gov/contact/',
                'dc_website' => 'https://www.whitehouse.gov/',
                'instagram' => 'https://www.instagram.com/whitehouse/',
                'facebook' => 'https://www.facebook.com/WhiteHouse',
                'twitter' => 'https://twitter.com/VP',
                'linkedin' => null, // No LinkedIn information provided
                'youtube' => 'https://www.youtube.com/user/whitehouse',
                'political_experience' => "President, United States Senate, 2021-present\n49th Vice President, United States of America, 2021-present\nSenator, United States Senate, California, 2017-2021\nCandidate, President of the United States, 2020\nCandidate, Vice-President of the United States, 2020\nAttorney General, State of California, 2011-2016\nCandidate, United States Senate, California, 2016\nCandidate, Attorney General, State of California, 2010, 2014",
                'professional_experience' => "Former Member, California Medical Assistance Commission\nFormer Member, Unemployment Insurance Appeals Board\nDistrict Attorney, City and County of San Francisco, 2004-2011\nChief, Community and Neighborhood Division, Office of the San Francisco City Attorney, 2000-2003\nAttorney, Career Criminal Unit, Office of the San Francisco District Attorney, 1998-2000\nDeputy District Attorney, Alameda County, 1990-1998",
                'military_experience' => null, // No military experience provided
                'other_experience' => "Former Fellow, Aspen Institute\nFormer Member, California District Attorneys Association Board\nVice President, National District Attorneys Association",
                'other_facts' => "Favorite Book:\nThe Kite Runner, Dreams From My Father, The Joy Luck Club, and Native Son\nFavorite Movie:\nLogan, Black Panther, Steel Magnolias, A Star is Born, My Cousin Vinny, Wonder Woman, Antwone Fisher, Ratatouille, Dark Knight\nFavorite Quote:\n\"You may be the first to do many things, but make sure you are not the last.\" - my mother, Shyamala G. Harris\nFavorite TV Shows:\n24, American Idol, anything on CNN, Baldwin Hills, 60 minutes, The Wire, Saturday Night Live, and VH1's Best Week Ever\nFavorite Type of Music:\nA Tribe Called Quest, Aretha Franklin, Bob Marley, Prince, Elton John, Too Short, John Legend, Raphael Saadiq, Ravi Shankar, Kendrick Lamar, Migos, Red Hot Chili Peppers, Carlos Santana, Miriam Makeba, Stevie Wonder, The Beatles, Maroon 5, The Jackson 5, Nina Simone\nHobbies or Special Talents:\nCooking, music, Farmer's Markets, movies, Sunday family dinners, spending time with my niece, and actually reading the entire Sunday New York Times on Sunday\nPublications:\n\"Smart on Crime: A Career Prosecutor's Plan to Make Us Safer\"\n\"The Truths We Hold: An American Journey\"",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'state' => 'United States of America',
                'user_name' => 'donald-trump',
                'first_name' => 'Donald',
                'last_name' => 'Trump',
                'party' => 'Republican',
                'jurisdiction' => 'United States of America',
                'city' => 'Mar-a-Lago, Palm Beach, FL',
                'committees' => null, // No committee information provided
                'birthday' => '1946-06-14',
                'religion' => 'Protestant',
                'on_the_ballot' => true,
                'birth_place' => 'Queens, NY',
                'home_city' => 'Mar-a-Lago, Palm Beach, FL',
                'education' => "BS, Economics/Real Estate, Wharton School of Finance, University of Pennsylvania, 1968\nAttended, Fordham University, 1964-1966",
                'contact_campaign_other' => 'TRUMP@REDCURVE.COM',
                'campaign_website' => 'https://www.donaldjtrump.com/',
                'dc_contact' => null, // No DC contact information provided
                'dc_website' => null, // No DC website information provided
                'instagram' => 'https://www.instagram.com/realdonaldtrump/',
                'facebook' => 'https://www.facebook.com/DonaldTrump/',
                'twitter' => 'https://twitter.com/TrumpWarRoom',
                'linkedin' => null, // No LinkedIn information provided
                'youtube' => 'https://www.youtube.com/channel/UCAql2DyGU2un1Ei2nMYsqOA',
                'political_experience' => "Candidate, President of the United States, 2016, 2020, 2024\n45th President, United States of America, 2017-2021",
                'professional_experience' => "Chair, Trump Hotels and Casino Resorts, Incorporated, 1995-present\nFormer Host, \"Trumped!\"\nFounder/Chair/President/Chief Executive Officer, The Trump Organization, 1975-2017\nProducer, \"The Apprentice\", 2004-2015\nHost, \"The Celebrity Apprentice\", 2008-2015\nFormer Owner, Miss Universe Organization, 1996-2015\nCo-Founder, Trump University, 2004-2010\nFormer Owner, Trump Shuttle, 1989-1992\nFormer Owner, New Jersey Generals, 1983-1985",
                'military_experience' => null, // No military experience provided
                'other_experience' => "Member, Benefactors Board of Directors, Historical Society of Palm Beach County\nMember, Board of Directors, Police Athletic League\nFormer Committee Member, Celebration of Nations\nFounding Member, Committee to Complete Construction of the Cathedral of Saint John the Divine\nFormer Chair, Donald J. Trump Foundation\nAdvisory Board Member, Lenox Hill Hospital\nCo-Chair, New York Vietnam Veterans Memorial Fund\nMember, Presidents Council of New York University\nFounding Member, The Wharton School Real Estate Center\nAdvisory Board Member, United Cerebral Palsy\nGrand Marshal, The Nation's Parade, 1995",
                'other_facts' => "Publications:\n\"Trump: The Art of the Deal\" - 1987\n\"Surviving at the Top\" - 1990\n\"Trump: The Art of the Comeback\" - 1997\n\"Trump: Think Like a Billionaire: Everything You Need to Know About Success, Real Estate, and Life\" - 2004\n\"Trump: How to Get Rich\" - 2004\n\"Trump: The Way to the Top: The Best Business Advice I Ever Received\" - 2004\n\"Trump: The Best Golf Advice I Ever Received\" - 2005\n\"Why We Want You To Be Rich: Two Men, One Message\" - 2006\n\"Trump: The Best Real Estate Advice I Ever Received: 100 Top Experts Share Their Strategies\" - 2006\n\"Trump 101: The Way to Success\" - 2006\n\"Trump Never Give Up: How I Turned My Biggest Challenges into Success\" - 2008\n\"Think Big: Make It Happen in Business and Life\" - 2008\n\"Think Like a Champion: An Informal Education In Business and Life\" - 2009\n\"Midas Touch: Why Some Entrepreneurs Get Rich and Why Most Don't\" - 2011\n\"Time to Get Tough: Make America Great Again!\" - 2011\n\"Great Again: How to Fix Our Crippled America\" - 2015",
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('executive_leaders');
    }
};
