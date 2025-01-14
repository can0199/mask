.. include:: ../Includes.txt

.. _fieldtypes:

===========
Field Types
===========

The Mask field types are a superset of the :ref:`TCA column types<t3tca:columns-types>`. If certain criterias meet, a
field will be assigned to a Mask field type. The criterias are specific TCA settings, which define the type of the
field. For example the TCA type `input` can have many appearances. With :php:`renderType => 'inputLink'` set, the field
transforms into a link field. Mask will assign it to the field type `Link` then. This is how core fields are displayed
as the appropriate field type.

.. toctree::
   :maxdepth: 1
   :titlesonly:

   Type/String
   Type/Integer
   Type/Float
   Type/Link
   Type/Colorpicker
   Type/Date
   Type/Datetime
   Type/Timestamp
   Type/Text
   Type/Richtext
   Type/Check
   Type/Radio
   Type/Select
   Type/Group
   Type/Inline
   Type/Content
   Type/File
   Type/Tab
   Type/Palette
   Type/Linebreak
