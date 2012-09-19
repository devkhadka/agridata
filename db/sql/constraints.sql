--
-- Constraints for dumped tables
--

--
-- Constraints for table `syn_collection_plan`
--
ALTER TABLE `syn_collection_plan`
  ADD CONSTRAINT `syn_collection_plan_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `syn_user` (`id`),
  ADD CONSTRAINT `syn_collection_plan_ibfk_1` FOREIGN KEY (`party_id`) REFERENCES `syn_party` (`id`);

--
-- Constraints for table `syn_dcr`
--
ALTER TABLE `syn_dcr`
  ADD CONSTRAINT `syn_dcr_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `syn_user` (`id`),
  ADD CONSTRAINT `syn_dcr_ibfk_1` FOREIGN KEY (`customer_title_id`) REFERENCES `syn_customertitle` (`id`),
  ADD CONSTRAINT `syn_dcr_ibfk_2` FOREIGN KEY (`approved_by`) REFERENCES `syn_user` (`id`);

--
-- Constraints for table `syn_infovalues`
--
ALTER TABLE `syn_infovalues`
  ADD CONSTRAINT `syn_infovalues_ibfk_2` FOREIGN KEY (`profile_id`) REFERENCES `syn_profile` (`id`),
  ADD CONSTRAINT `syn_infovalues_ibfk_1` FOREIGN KEY (`info_id`) REFERENCES `syn_infotitle` (`id`);

--
-- Constraints for table `syn_ndprice`
--
ALTER TABLE `syn_ndprice`
  ADD CONSTRAINT `syn_ndprice_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `syn_user` (`id`),
  ADD CONSTRAINT `syn_ndprice_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `syn_product` (`id`);

--
-- Constraints for table `syn_party`
--
ALTER TABLE `syn_party`
  ADD CONSTRAINT `syn_party_ibfk_1` FOREIGN KEY (`profile_id`) REFERENCES `syn_profile` (`id`);

--
-- Constraints for table `syn_partystock`
--
ALTER TABLE `syn_partystock`
  ADD CONSTRAINT `syn_partystock_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `syn_user` (`id`),
  ADD CONSTRAINT `syn_partystock_ibfk_1` FOREIGN KEY (`party_id`) REFERENCES `syn_party` (`id`),
  ADD CONSTRAINT `syn_partystock_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `syn_product` (`id`);

--
-- Constraints for table `syn_party_due`
--
ALTER TABLE `syn_party_due`
  ADD CONSTRAINT `syn_party_due_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `syn_user` (`id`),
  ADD CONSTRAINT `syn_party_due_ibfk_1` FOREIGN KEY (`party_id`) REFERENCES `syn_party` (`id`);

--
-- Constraints for table `syn_party_user`
--
ALTER TABLE `syn_party_user`
  ADD CONSTRAINT `syn_party_user_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `syn_user` (`id`),
  ADD CONSTRAINT `syn_party_user_ibfk_1` FOREIGN KEY (`party_id`) REFERENCES `syn_party` (`id`);

--
-- Constraints for table `syn_product`
--
ALTER TABLE `syn_product`
  ADD CONSTRAINT `syn_product_ibfk_1` FOREIGN KEY (`unit_id`) REFERENCES `syn_unit` (`id`);

--
-- Constraints for table `syn_sales_plan`
--
ALTER TABLE `syn_sales_plan`
  ADD CONSTRAINT `syn_sales_plan_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `syn_user` (`id`),
  ADD CONSTRAINT `syn_sales_plan_ibfk_1` FOREIGN KEY (`party_id`) REFERENCES `syn_party` (`id`);

--
-- Constraints for table `syn_sales_plan_detail`
--
ALTER TABLE `syn_sales_plan_detail`
  ADD CONSTRAINT `syn_sales_plan_detail_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `syn_product` (`id`),
  ADD CONSTRAINT `syn_sales_plan_detail_ibfk_1` FOREIGN KEY (`sales_plan_id`) REFERENCES `syn_sales_plan` (`id`);

--
-- Constraints for table `syn_tada`
--
ALTER TABLE `syn_tada`
  ADD CONSTRAINT `syn_tada_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `syn_user` (`id`);

--
-- Constraints for table `syn_tasetting`
--
ALTER TABLE `syn_tasetting`
  ADD CONSTRAINT `syn_tasetting_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `syn_user` (`id`);

--
-- Constraints for table `syn_user`
--
ALTER TABLE `syn_user`
  ADD CONSTRAINT `syn_user_ibfk_1` FOREIGN KEY (`profile_id`) REFERENCES `syn_profile` (`id`),
  ADD CONSTRAINT `syn_user_ibfk_2` FOREIGN KEY (`manager_id`) REFERENCES `syn_user` (`id`);

--
-- Constraints for table `syn_visit_plan`
--
ALTER TABLE `syn_visit_plan`
  ADD CONSTRAINT `syn_visit_plan_ibfk_2` FOREIGN KEY (`approved_by`) REFERENCES `syn_user` (`id`),
  ADD CONSTRAINT `syn_visit_plan_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `syn_user` (`id`);
