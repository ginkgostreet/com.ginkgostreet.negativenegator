# Negative Negator
A CiviCRM extension that provides form validation to prevent negative values from being entered in Text / Numeric Quantity fields in Price Sets. This extension was created specifically to address this issue: https://lab.civicrm.org/dev/financial/issues/31

## Background and Context
A client recently made the unwelcome discovery that open donation fields in price sets, such as would be configured on an event or membership price set to collect an additional donation, allow negative numbers/quantities to be entered. This means that a clever and unscrupulous event registrant can give themselves a discount, up to the full event price, on any event registration containing such a field. This same technique can be used to "purchase" free memberships. One way around this could be to use a multiple choice field, but the client felt it important to allow voluntary additional donations of any size.

## Articulation of minimum requirement
Negative quantities should be disallowed on price fields, in particular price fields of type Text / Numeric Quantity. This does not mean the amount being added to the total price for a singular field cannot be negative i.e. the Unit Price of a Price Field can be configured to be negative, which combined with a positive quantity, would mean a negative dollar amount would be added to the total for the Price Set.

## Usage
Install from GitHub or the CiviCRM Extensions directory, enable, and enjoy worry-free disallowment of negative values in all text/numeric quantity fields site-wide. Need some users to be allowed to enter negative values, such as for the purpose of creating instant "ad-hoc" discounts on events and the like? Well, you probably SHOULD configure your text/numeric quantity field to have a negative Unit Price value and then enter a positive quantity value. But if you already have a rash of these fields configured wth positive Unit Prices, just enable the included "CiviContribute: allow negative values in price fields" (name TBD) permission for the appropriate roles, and Bingo's your monkey.
