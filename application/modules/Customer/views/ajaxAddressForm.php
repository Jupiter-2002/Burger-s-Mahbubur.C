<tr class="even" style="border: 1px solid green;">
    <td width="100%" class="table-detail-font1">

        <div class="form-right">
            <form  name="AddressForm" id="AddressForm">
                <div class="element1">
                    <div class="heading">Address Form</div>

                    <div class="content-area">
                        <div class="left">
                            <div class="left-text">Label :<sup><span style="color:#FF0000; font-size:12px; font-size:10px;">*</span></sup></div>
                        </div>
                        <div class="right">
                            <div>
                                <input type="text" style="text-transform: uppercase;" onfocus="" name="CustAddLabel" id="CustAddLabel" class="input1 onlyCharWithSpace" value="">
                                <p id="Error_CustAddLabel" name="Error_CustAddLabel" class="clsAddAddressError" style="color: red; display: none;"></p>
                            </div>
                        </div>
                    </div>
                    <div class="content-area">
                        <div class="left">
                            <div class="left-text">Contact Number :<sup><span style="color:#FF0000; font-size:12px; font-size:10px;">*</span></sup></div>
                        </div>
                        <div class="right">
                            <div>
                                <input type="text" onfocus="" name="CustContact" id="CustContact" class="input1" value="" required>
                                <p id="Error_CustContact" name="Error_CustContact" class="clsAddAddressError" style="color: red; display: none;"></p>
                            </div>
                        </div>
                    </div>
                    <div class="content-area">
                        <div class="left">
                            <div class="left-text">Address 1 :<sup><span style="color:#FF0000; font-size:12px; font-size:10px;">*</span></sup></div>
                        </div>
                        <div class="right">
                            <div>
                                <input type="text" onfocus="" name="CustAddress1" id="CustAddress1" class="input1 onlyCharWithSpace" value="" required>
                                <p id="Error_CustAddress1" name="Error_CustAddress1" class="clsAddAddressError" style="color: red; display: none;"></p>
                            </div>
                        </div>
                    </div>
                    <div class="content-area">
                        <div class="left">
                            <div class="left-text">Address 2 :</div>
                        </div>
                        <div class="right">
                            <div>
                                <input type="text" onfocus="" name="CustAddress2" id="CustAddress2" class="input1 onlyCharWithSpace" value="">
                                <p id="Error_CustAddress2" name="Error_CustAddress2" class="clsAddAddressError" style="color: red; display: none;"></p>
                            </div>
                        </div>
                    </div>
                    <div class="content-area">
                        <div class="left">
                            <div class="left-text">City :<sup><span style="color:#FF0000; font-size:12px; font-size:10px;">*</span></sup></div>
                        </div>
                        <div class="right">
                            <div>
                                <input type="text" onfocus="" name="CustCity" id="CustCity" class="input1 onlyAlphabateWithSpace" value="" required>
                                <p id="Error_CustCity" name="Error_CustCity" class="clsAddAddressError" style="color: red; display: none;"></p>
                            </div>
                        </div>
                    </div>
                    <div class="content-area">
                        <div class="left">
                            <div class="left-text">Post Code :<sup><span style="color:#FF0000; font-size:12px; font-size:10px;">*</span></sup></div>
                        </div>
                        <div class="right">
                            <div>
                                <input type="text" style="text-transform: uppercase;" onfocus="" name="CityPostCode" id="CityPostCode" class="input1 onlyCharWithSpace" value="" required>
                                <p id="Error_CityPostCode" name="Error_CityPostCode" class="clsAddAddressError" style="color: red; display: none;"></p>
                            </div>
                        </div>
                    </div>

                    <div class="content-area">
                        <div class="left">
                            <div class="left-text">&nbsp;</div>
                        </div>
                        <div class="right">
                            <div>
                                <input type="button" value="Add Address" class="common-btn" onclick="newAddressFormSubmit()">

                                <input type="button" value="CANCEL" class="cancle-btn" onclick="getAddressDetails()">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </td>
</tr>

<script type="text/javascript">
    //  This is to add different Validations based on HTML Class [assets/js/utility.js]
    addCustomeClassValidator();
</script>