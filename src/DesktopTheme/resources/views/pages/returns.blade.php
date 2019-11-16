@extends('layouts.3columns')


@push('styles')
    .widget-title {
        font-weight: 300;
        line-height: 1.1;
        font-size: 1.6rem;
        margin-top: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .list-icon {
        list-style: outside none none;
        margin-top: 0rem;
        margin-bottom: 2.5rem;
    }

    .list-icon > li {
        margin-top: 0rem;
        margin-bottom: 0.5rem;
    }

    .main-title {
        font-weight: 700;
        text-decoration: underline;
    }

    .sub-title {
        font-weight: 700;
        text-decoration: underline;
    }
    .inner-bold{
        font-weight: 700;
        text-decoration: underline;
    }
@endpush

@section('custom')
    <section>
        <div class="container mb-5">
            <h6 class="main-title">RETURN POLICY</h6>

            <p class="sub-title mt-5">Incorrectly purchased items or return of unwanted items</p>

            <p>1.You must first contact us to speak to our customer service team regarding the items you wish to return, they will need to determine whether items are still acceptable for return matching to the criteria below;</p>

            <p>Item/s must be unopened, undamaged, unmarked and maintained in the original condition/ original packaging in which it is still at a re-sellable state. There is no exception to this</p>

            <p>Item/s to be returned must have valid invoice record, items must be originally purchased from TonerCity</p>

            <p>Item/s must be within 3 months of purchase from invoice date, we do not accept any items returned beyond this specified period. If you are not sure when items were purchased, please do not hesitate to contact us for assistance.</p>

            <p>2. Once you have obtained the RA number from us, you will be provided with the address details to proceed with the return. It is your responsibility to pay for the return freight charges to send the items back to us. Items that are shipped labelled with “receiver to pay” will be rejected by our warehouse team, leaving the courier responsible. Please note that it is your responsibility to return the items back to us with a valid tracking ID or Proof of delivery (POD) to ensure items have been returned safely back to us. We are not responsible for any lost parcel return without parcel tracking ID. We would therefore strongly recommend you to return items back to us using registered post.</p>

            <p>3. Please also ensure incorrectly purchased items are packed safely in another box. This will prevent any unnecessary damage to the original packaging caused by courier handling and sticker labelling during transit.</p>

            <p>4. Once RA number has been assigned to you with the instructed details and procedures, it is your responsibility to arrange the return of the items back to us within 14 days. So please arrange for return at your earliest convenience as your RA number will only be valid for use for 14 days.</p>

            <p>5. All items returned back to Alphazento due to the reason of incorrect purchase or unwanted items will incur a 20% restocking fee. This fee will be deducted from the value of the total approved return. The remaining balance after fee deduction will be issued as a store credit.</p>

            <p class="sub-title mt-5">Faulty items</p>

            <p>For return of any faulty compatible items, please follow the procedure below.</p>

            <p>1. You must first contact us to speak to our customer service team regarding the items you wish to return. We will first assess the problem according to your situation before proceeding to further arrangements</p>

            <p>2. For any fault linking to a print quality issue, we will request our customers to print a copy of a test page. Customer must follow the request instructed by our customer service team before we proceed to the appropriate solution. We will not be able to proceed to appropriate solution if a test page cannot be supplied on request.</p>

            <p>3. Once cartridges have been deemed faulty, we will be able to issue you a replacement cartridge. Or alternatively a credit will be issued upon receipt of the faulty cartridge. Please note that cartridges have to be over a minimum weight (normally at least 75% full) before we can accept them for return</p>

            <p>4. If the product has been refilled or tampered with in any way, we will not be able to issue a credit of this return</p>

            <p>5. It is vital for all returning cartridges to be sealed and packaged securely to ensure cartridges do not leak or get lost in transit</p>

            <p class="mt-4">Genuine OEM items will be referred back to its original manufacturers for further diagnose. Please do not hesitate to contact our customer service team for further information. They will be able to direct you to the appropriate point of contact associated to original brand manufacturer. You can also find further information from <span class="inner-bold">Warranty for OEM brand products</span>. This is a necessary procedure, as the end user often may assume the problem is cartridge related and may quickly jump to the conclusion that the cartridge is faulty. However often by first contacting the original manufacturer regarding the issue, they may be able to help trouble shoot the issue before deeming the item to be faulty. In most cases, they may be able to resolve the issue for you through their own technical support team. Otherwise where applicable, OEM brands such as Brother, Canon, Epson, HP, Konica Minolta, Kyocera and Samsung will require end users to first return the suspected faulty product back to us and we will need to forward it to the relevant OEM manufacturer to assess the product. If the product is deemed to be defective, we will be able to issue you a replacement or credit. However, this process may take up to 3- 4 weeks to complete.</p>

            <p>PLEASE NOTE THAT WE WILL NOT ISSUE ANY CREDITS ON RETURNS WHERE ITEMS RETURNED FAIL TO MEET THE CONDITIONS OUTLINED ABOVE.</p>

            <h6 class="main-title mt-5">WARRANTY</h6>

            <p class="sub-title mt-5">For Compatible products (non-genuine brand items)</p>

            <p>All of our premium compatible products will include 1 year warranty from the date of purchase. Should you experience any problems or if you are not completely satisfied with our products, please do not hesitate to contact us. Please also view the return policy on faulty items for further info.</p>

            <p class="sub-title mt-5">For OEM brand products</p>

            <p>Manufacturer’s warranty will apply to genuine brand OEM cartridges, which is generally valid for 90 days from invoice date. Exception may apply to some special circumstances. If you experience any problems or not completely satisfied with our products, please do not hesitate to contact us. Depending on the type of problem you have encountered, we will find the solution appropriate to your purchase.</p>

            <p class="mb-4">For OEM consumable brands such as <span class="inner-bold">Brother, Canon, Epson, HP, Konica Minolta and Kyocera,</span></p>

            <p>1. You will need to first contact us and let our customer service team know of the issues associated with the item. Depending on your situation, we may recommend for you to first contact the support team from the relevant OEM brand as this may sometimes help eliminate minor faults using methods provided by their technical support team</p>

            <p>2. If the recommendations have not resolve the issue then please let us know and we will arrange to collect the item, so we can forward this to the appropriate OEM brand for further assessment on the item. For items linked to these brands, we will require for cartridges to meet a minimum weight requirement. Relevant print samples of the fault must be included to assist with the assessment.</p>

            <p>3. If the item is deemed to be defective, we will be able to issue you a replacement or credit. However, please understand that this process may take up to 3- 4 weeks to complete.</p>

            <p class="mt-4">For some other particular OEM brand such as <span class="inner-bold">Fuji Xerox, Lexmark, Oki, Panasonic, and Samsung,</span>  the end users are required to contact them directly for technical support should the end user suspect the consumables to be at fault. Their support team will guide you through a diagnostic procedure to determine possible faults. If they deem the item to be at fault, then they will advise the customer on the required procedure to obtain a replacement and in most cases be able to offer replacement directly.</p>

            <p class="sub-title mt-4">Fuji Xerox</p>

            <p>For Fuji Xerox consumables, we will require end users to contact the Fuji Xerox customer Service Centre on 1800 811 177 and follow the voice prompts to the technical Support department. Customer can then discuss their issue with the technical Support team. Depending on the circumstances, Fuji Xerox may direct the customer to forward the faulty item to their nearest OKI representative for assessment. If Fuji Xerox deems the item to be faulty, Fuji Xerox will issue a replacement stock.</p>

            <p>Alternatively Fuji Xerox customer service support team can be contacted via email at <a href="mailto:support.aus@fujixerox.com">support.aus@fujixerox.com</a></p>

            <p class="sub-title mt-4">Lexmark</p>

            <p>For Lexmark consumables, we will require end users to contact Lexmark Technical Support on Tel: 1300 362 192, select option 3 to speak to a support staff. If the item is deemed faulty, the end user will generally be given a job/ reference number and referred by technical support to point of purchase for replacement.</p>

            <p class="sub-title mt-4">OKI</p>

            <p>For OKI consumables, we will require end users to contact customer service centre on 1800 807 472 and follow the voice prompts to the technical Support department. Customer can then discuss their issue with the technical Support team. Depending on the circumstances, OKI may direct the customer to forward the faulty item to their nearest OKI representative for assessment. If OKI deems the item to be faulty, OKI will issue a replacement stock.</p>

            <p class="sub-title mt-4">Panasonic</p>

            <p>If you have problem associated to Panasonic fax rolls, toner or drum, end user must first call the Panasonic service centre 132 600 for assistance. They should advise you on the procedure for faulty item assessment. In the event where the item needs to be forwarded to Panasonic for further assessment to confirm the potential fault, they will require three items of information in order to proceed. This will include a sample of what faulty the products are doing, meter readings of when the toner/ drum were installed and a meter reading of when it faulted. Panasonic are very strict with this, they will not assess the goods unless all three pieces of information are provided.</p>

            <p class="sub-title mt-4">Samsung</p>

            <p>For Samsung consumables, we will require end users to contact Samsung customer care centre on 1300 362 603. Customer can then discuss their issue with the technical Support team. If the item is deemed to be potentially faulty, the end user will generally be given a job/ reference number. You can contact us back with this job number and our team member will arrange to have this item collected and be forwarded to Samsung for further assessment. Please include a print sample of the fault associated to the item. Once assessment is approved and the item is deemed to be at fault, we will be able to issue a replacement or credit</p>

            <p class="mt-4">We would like to thank you in advance for your patience and understanding for the processing time and necessary procedures required to resolve any potential faulty item issues. Should you have any enquiry, our friendly customer service team will be here to guide you through the process.</p>

            <p>Please be aware that warranty does not apply to cartridges which have been damaged by improper usage/ installation or have been altered and used beyond normal operation. Please also note that the warranty is limited to the costs of the goods only, which is the amount stated on your invoice. There are no implied warranties beyond what is stated here.</p>
        </div>
    </section>
@endsection
