<div x-data="{language: 'dutch'}">
    <div class="flex mt-3 mb-12">
        <h1 class="flex-1 text-4xl font-light pt-3">
            Health Check
        </h1>
        <div class="bg-white rounded p-2">
            <button
                @click="language = 'dutch'"
                :class="language == 'dutch' ? 'text-white bg-purple-500 border border-purple-500' : 'text-purple-500 bg-white border-white '"
                class="font-bold py-4 px-6 rounded leading-normal border hover:text-white hover:bg-purple-500"
            >
                Dutch
            </button>
            <button
                @click="language = 'english'"
                :class="language == 'english' ? 'text-white bg-purple-500 border border-purple-500' : 'text-purple-500 bg-white border-white '"
                class="font-bold py-4 px-6 rounded leading-normal border hover:text-white hover:bg-purple-500"
            >
                English
            </button>
        </div>
    </div>


    <div x-show="language == 'dutch'" class="leading-normal">
        <p class="mb-6 font-bold leading-normal">
            Stel de volgende vragen aan de gasten. Is het antwoord op 1 van deze
            vragen ja? Helaas kan de gast deze avond niet toegelaten worden, vraag
            de persoon naar huis te gaan.
        </p>

        <x-health-check-rule number="1">
            Had je een of meerdere van deze <strong>klachten in de afgelopen 24 uur</strong>?<br />
            Hoesten, neusverkoudheid, koorts, benauwdheidsklachten
        </x-health-check-rule>

        <x-health-check-rule number="2">
            Heb je op dit moment een <strong>huisgenoot met koorts en/of benauwdheidsklachten</strong>?
        </x-health-check-rule>

        <x-health-check-rule number="3">
            Heb je het <strong>coronavirus gehad</strong> en is dit de <strong>afgelopen 7 dagen</strong> vastgesteld (in een lab)?
        </x-health-check-rule>

        <x-health-check-rule number="4">
            Heb je een <strong>huisgenoot/gezinslid met het coronavirus</strong> en heb je in de <strong>afgelopen 14 dagen</strong> contact met hem/haar gehad terwijl de persoon nog klachten had?
        </x-health-check-rule>

        <x-health-check-rule number="5">
            <strong>Ben je in quarantaine</strong> omdat je direct contact hebt gehad met iemand waarbij het coronavirus is vastgesteld?
        </x-health-check-rule>
    </div>

    <div x-show="language == 'english'" class="leading-normal">
        <p class="mb-6 font-bold leading-normal">
            Please ask guests the following questions. Is the answer to any of these
            questions yes? Unfortunately, the guest cannot be admitted this night,
            please ask the person to go home.
        </p>

        <x-health-check-rule number="1">
            Did you have any of these health <strong>complaints in the last 24 hours</strong>?
            Coughing, a cold, fever, respiratory complaints
        </x-health-check-rule>

        <x-health-check-rule number="2">
            Is there a member of your <strong>household with fever or respiratory complaints</strong> at the moment?
        </x-health-check-rule>

        <x-health-check-rule number="3">
            Have you <strong>had the corona virus</strong> and was this diagnosed by a lab <strong>in the last 7 days</strong>?
        </x-health-check-rule>

        <x-health-check-rule number="4">
            Have you been <strong>in contact</strong> with a member of your <strong>household with the corona virus</strong> in the <strong>last 14 days</strong> while that person still had complaints?
        </x-health-check-rule>

        <x-health-check-rule number="5">
            <strong>Are you in quarantine</strong> because you have been in direct contact with a person diagnosed with the corona virus?
        </x-health-check-rule>
    </div>
</div>
